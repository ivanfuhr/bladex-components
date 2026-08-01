/**
 * Stencil — accessible toggle button (vanilla JS, no Alpine).
 */

const TOGGLE_SELECTOR = '[data-toggle]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initToggles(root = document) {
    root.querySelectorAll(TOGGLE_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLButtonElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        // Group items are handled by toggle-group.js.
        if (element.closest('[data-toggle-group]')) {
            return;
        }

        initialized.add(element);
        bindToggle(element);
    });
}

/**
 * @param {HTMLButtonElement} button
 */
function bindToggle(button) {
    const setPressed = (pressed) => {
        button.dataset.state = pressed ? 'on' : 'off';
        button.setAttribute('aria-pressed', pressed ? 'true' : 'false');

        button.dispatchEvent(
            new CustomEvent('stencil:toggle:change', {
                bubbles: true,
                detail: { pressed },
            }),
        );
    };

    button.addEventListener('click', () => {
        if (button.disabled) {
            return;
        }

        setPressed(button.getAttribute('aria-pressed') !== 'true');
    });
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initToggles(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initToggles());
    } else {
        initToggles();
    }
}
