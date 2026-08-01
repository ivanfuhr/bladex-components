/**
 * Stencil — input mask, password reveal, copy, and character counter (vanilla JS).
 */

const INPUT_ENHANCED_SELECTOR = '[data-input-enhanced]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initInputEnhancements(root = document) {
    root.querySelectorAll(INPUT_ENHANCED_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindInputEnhancements(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindInputEnhancements(root) {
    /** @type {HTMLInputElement | null} */
    const control = root.querySelector('[data-input-control]');

    if (!(control instanceof HTMLInputElement)) {
        return;
    }

    const maskPattern = root.getAttribute('data-input-mask') ?? '';
    const viewable = root.hasAttribute('data-input-viewable');
    const copyable = root.hasAttribute('data-input-copyable');
    const counter = root.hasAttribute('data-input-counter');

    if (maskPattern !== '') {
        bindMask(control, maskPattern);
    }

    if (viewable) {
        bindViewable(control, root);
    }

    if (copyable) {
        bindCopyable(control, root);
    }

    if (counter) {
        bindCounter(control, root);
    }
}

/**
 * @param {string} pattern
 * @returns {Array<{ type: 'literal' | 'digit' | 'letter', value: string }>}
 */
function parseMask(pattern) {
    /** @type {Array<{ type: 'literal' | 'digit' | 'letter', value: string }>} */
    const tokens = [];

    for (let i = 0; i < pattern.length; i += 1) {
        const char = pattern[i];

        if (char === '#') {
            tokens.push({ type: 'digit', value: char });
        } else if (char === 'A') {
            tokens.push({ type: 'letter', value: char });
        } else {
            tokens.push({ type: 'literal', value: char });
        }
    }

    return tokens;
}

/**
 * @param {{ type: 'literal' | 'digit' | 'letter', value: string }} token
 * @param {string} char
 * @returns {boolean}
 */
function matchesMaskSlot(token, char) {
    if (token.type === 'digit') {
        return /\d/.test(char);
    }

    if (token.type === 'letter') {
        return /[a-zA-Z]/.test(char);
    }

    return false;
}

/**
 * @param {HTMLInputElement} control
 * @param {string} pattern
 */
function bindMask(control, pattern) {
    const tokens = parseMask(pattern);

    function formatValue(raw) {
        const chars = [...raw].filter((char) => /\d/.test(char) || /[a-zA-Z]/.test(char));
        let charIndex = 0;
        let output = '';

        for (const token of tokens) {
            if (token.type === 'literal') {
                output += token.value;
                continue;
            }

            while (charIndex < chars.length && !matchesMaskSlot(token, chars[charIndex])) {
                charIndex += 1;
            }

            if (charIndex >= chars.length) {
                break;
            }

            output += chars[charIndex];
            charIndex += 1;
        }

        return output;
    }

    control.addEventListener('input', () => {
        const formatted = formatValue(control.value);
        control.value = formatted;
    });
}

/**
 * @param {HTMLInputElement} control
 * @param {HTMLElement} root
 */
function bindViewable(control, root) {
    const toggle = root.querySelector('[data-input-view-toggle]');

    if (!(toggle instanceof HTMLButtonElement)) {
        return;
    }

    toggle.addEventListener('click', (event) => {
        event.preventDefault();

        const isPassword = control.type === 'password';
        control.type = isPassword ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
    });
}

/**
 * @param {HTMLInputElement} control
 * @param {HTMLElement} root
 */
function bindCopyable(control, root) {
    const button = root.querySelector('[data-input-copy]');

    if (!(button instanceof HTMLButtonElement)) {
        return;
    }

    button.addEventListener('click', async (event) => {
        event.preventDefault();

        const value = control.value;

        if (value === '') {
            return;
        }

        try {
            await navigator.clipboard.writeText(value);
        } catch {
            const helper = document.createElement('textarea');
            helper.value = value;
            helper.style.position = 'fixed';
            helper.style.left = '-9999px';
            document.body.appendChild(helper);
            helper.select();
            document.execCommand('copy');
            helper.remove();
        }
    });
}

/**
 * @param {HTMLInputElement} control
 * @param {HTMLElement} root
 */
function bindCounter(control, root) {
    const counterEl = root.querySelector('[data-input-counter-display]');

    if (!(counterEl instanceof HTMLElement)) {
        return;
    }

    const maxLength = control.maxLength > 0 ? control.maxLength : null;

    function update() {
        const length = control.value.length;
        counterEl.textContent = maxLength !== null ? `${length}/${maxLength}` : String(length);
    }

    control.addEventListener('input', update);
    update();
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initInputEnhancements(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initInputEnhancements());
    } else {
        initInputEnhancements();
    }
}
