/**
 * Std Components — accessible tabs (vanilla JS, no Alpine).
 */

const TABS_SELECTOR = '[data-tabs]';
const TRIGGER_SELECTOR = '[data-tabs-trigger]';
const CONTENT_SELECTOR = '[data-tabs-content]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initTabs(root = document) {
    root.querySelectorAll(TABS_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindTabs(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindTabs(root) {
    const triggers = () =>
        Array.from(root.querySelectorAll(TRIGGER_SELECTOR)).filter(
            (node) => node instanceof HTMLButtonElement && !node.disabled,
        );

    const contents = () =>
        Array.from(root.querySelectorAll(CONTENT_SELECTOR)).filter(
            (node) => node instanceof HTMLElement,
        );

    const activate = (value) => {
        root.dataset.active = value;

        triggers().forEach((trigger) => {
            const selected = trigger.dataset.value === value;
            trigger.dataset.state = selected ? 'active' : 'inactive';
            trigger.setAttribute('aria-selected', selected ? 'true' : 'false');
            trigger.tabIndex = selected ? 0 : -1;
        });

        contents().forEach((panel) => {
            const selected = panel.dataset.value === value;
            panel.dataset.state = selected ? 'active' : 'inactive';
            panel.hidden = !selected;
            panel.classList.toggle('hidden', !selected);
        });

        root.dispatchEvent(
            new CustomEvent('std:tabs:change', {
                bubbles: true,
                detail: { value },
            }),
        );
    };

    const initial =
        root.dataset.active ||
        triggers().find((trigger) => trigger.dataset.state === 'active')?.dataset.value ||
        triggers()[0]?.dataset.value;

    if (typeof initial === 'string' && initial !== '') {
        activate(initial);
    }

    root.addEventListener('click', (event) => {
        const trigger =
            event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR) : null;

        if (
            !(trigger instanceof HTMLButtonElement) ||
            !root.contains(trigger) ||
            trigger.disabled
        ) {
            return;
        }

        const value = trigger.dataset.value;

        if (typeof value === 'string') {
            activate(value);
        }
    });

    root.addEventListener('keydown', (event) => {
        const trigger =
            event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR) : null;

        if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger)) {
            return;
        }

        const enabled = triggers();
        const index = enabled.indexOf(trigger);
        const orientation = root.dataset.orientation || 'horizontal';
        const nextKey = orientation === 'vertical' ? 'ArrowDown' : 'ArrowRight';
        const prevKey = orientation === 'vertical' ? 'ArrowUp' : 'ArrowLeft';

        let nextIndex = index;

        if (event.key === nextKey) {
            nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
        } else if (event.key === prevKey) {
            nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
        } else if (event.key === 'Home') {
            nextIndex = 0;
        } else if (event.key === 'End') {
            nextIndex = enabled.length - 1;
        } else {
            return;
        }

        event.preventDefault();
        const next = enabled[nextIndex];

        if (next instanceof HTMLButtonElement && typeof next.dataset.value === 'string') {
            activate(next.dataset.value);
            next.focus();
        }
    });
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initTabs(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initTabs());
    } else {
        initTabs();
    }
}
