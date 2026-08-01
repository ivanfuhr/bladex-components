/**
 * Stencil — pillbox / tags input (vanilla JS, no Alpine).
 */

const PILLBOX_SELECTOR = '[data-pillbox]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initPillboxes(root = document) {
    root.querySelectorAll(PILLBOX_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindPillbox(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindPillbox(root) {
    const list = root.querySelector('[data-pillbox-list]');
    /** @type {HTMLInputElement | null} */
    const textInput = root.querySelector('[data-pillbox-input]');
    const hiddenContainer = root.querySelector('[data-pillbox-hidden-inputs]');
    /** @type {HTMLTemplateElement | null} */
    const chipTemplate = root.querySelector('template[data-pillbox-chip-template]');
    const fieldName = root.getAttribute('data-pillbox-name') ?? '';
    const maxAttr = root.getAttribute('data-pillbox-max');
    const max = maxAttr !== null && maxAttr !== '' ? Number.parseInt(maxAttr, 10) : null;
    const disabled = root.hasAttribute('data-disabled');

    /** @type {string[]} */
    let tags = [];

    try {
        const parsed = JSON.parse(root.getAttribute('data-pillbox-value') ?? '[]');

        if (Array.isArray(parsed)) {
            tags = parsed.map(String).filter((tag) => tag.trim() !== '');
        }
    } catch {
        tags = [];
    }

    if (
        !(list instanceof HTMLElement) ||
        !(textInput instanceof HTMLInputElement) ||
        !(hiddenContainer instanceof HTMLElement) ||
        !(chipTemplate instanceof HTMLTemplateElement) ||
        fieldName === ''
    ) {
        return;
    }

    /**
     * @param {HTMLElement} target
     */
    function dispatchChange(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @returns {string[]}
     */
    function getTags() {
        return [...tags];
    }

    /**
     * @param {string[]} values
     */
    function setTags(values) {
        const unique = [];

        values.forEach((value) => {
            const trimmed = value.trim();

            if (trimmed === '' || unique.includes(trimmed)) {
                return;
            }

            unique.push(trimmed);
        });

        if (max !== null && unique.length > max) {
            unique.length = max;
        }

        tags = unique;
        render();
        dispatchChange(root);
    }

    function renderChips() {
        list.replaceChildren();

        tags.forEach((tag, index) => {
            const fragment = chipTemplate.content.cloneNode(true);
            const chip =
                fragment instanceof DocumentFragment
                    ? fragment.querySelector('[data-pillbox-chip]')
                    : null;

            if (!(chip instanceof HTMLElement)) {
                return;
            }

            const label = chip.querySelector('[data-pillbox-chip-label]');

            if (label instanceof HTMLElement) {
                label.textContent = tag;
            }

            const removeButton = chip.querySelector('[data-pillbox-chip-remove]');

            if (removeButton instanceof HTMLButtonElement) {
                removeButton.disabled = disabled;
                removeButton.addEventListener('click', (event) => {
                    event.preventDefault();

                    if (disabled) {
                        return;
                    }

                    const next = getTags();
                    next.splice(index, 1);
                    setTags(next);
                    textInput.focus();
                });
            }

            list.appendChild(fragment);
        });
    }

    function renderHiddenInputs() {
        hiddenContainer.replaceChildren();

        tags.forEach((tag) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = fieldName;
            input.value = tag;
            input.setAttribute('data-pillbox-hidden-input', '');
            hiddenContainer.appendChild(input);
        });
    }

    function render() {
        renderChips();
        renderHiddenInputs();

        const atMax = max !== null && tags.length >= max;
        textInput.disabled = disabled || atMax;
        textInput.placeholder =
            atMax && max !== null
                ? ''
                : (textInput.getAttribute('data-original-placeholder') ?? textInput.placeholder);
    }

    /**
     * @param {string} raw
     */
    function addFromInput(raw) {
        const parts = raw
            .split(',')
            .map((part) => part.trim())
            .filter((part) => part !== '');

        if (parts.length === 0) {
            return;
        }

        setTags([...getTags(), ...parts]);
        textInput.value = '';
    }

    textInput.setAttribute('data-original-placeholder', textInput.placeholder);

    textInput.addEventListener('keydown', (event) => {
        if (disabled) {
            return;
        }

        if (event.key === 'Enter' || event.key === ',') {
            event.preventDefault();

            if (textInput.value.trim() !== '') {
                addFromInput(textInput.value);
            }

            return;
        }

        if (event.key === 'Backspace' && textInput.value === '' && tags.length > 0) {
            event.preventDefault();
            const next = getTags();
            next.pop();
            setTags(next);
        }
    });

    textInput.addEventListener('blur', () => {
        if (disabled) {
            return;
        }

        if (textInput.value.trim() !== '') {
            addFromInput(textInput.value);
        }
    });

    render();
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initPillboxes(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initPillboxes());
    } else {
        initPillboxes();
    }
}
