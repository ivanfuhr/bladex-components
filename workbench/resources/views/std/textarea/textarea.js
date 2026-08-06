/**
 * Std Components — autosize textarea and character counter (vanilla JS).
 */

const TEXTAREA_SELECTOR = '[data-textarea]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initTextareas(root = document) {
    root.querySelectorAll(TEXTAREA_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindTextarea(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindTextarea(root) {
    /** @type {HTMLTextAreaElement | null} */
    const control = root.querySelector('[data-textarea-control]');

    if (!(control instanceof HTMLTextAreaElement)) {
        return;
    }

    const autosize = root.hasAttribute('data-textarea-autosize');
    const counter = root.hasAttribute('data-textarea-counter');
    const counterEl = root.querySelector('[data-textarea-counter-display]');

    if (autosize) {
        const resize = () => {
            control.style.height = 'auto';
            control.style.height = `${control.scrollHeight}px`;
        };

        control.addEventListener('input', resize);
        resize();
    }

    if (counter && counterEl instanceof HTMLElement) {
        const maxLength = control.maxLength > 0 ? control.maxLength : null;

        const update = () => {
            const length = control.value.length;
            counterEl.textContent = maxLength !== null ? `${length}/${maxLength}` : String(length);
        };

        control.addEventListener('input', update);
        update();
    }
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initTextareas(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initTextareas());
    } else {
        initTextareas();
    }
}
