/**
 * Stencil — accessible stepper / wizard steps (vanilla JS, no Alpine).
 */

const STEPPER_SELECTOR = '[data-stepper]';
const ITEM_SELECTOR = '[data-stepper-item]';
const TRIGGER_SELECTOR = '[data-stepper-trigger]';
const CONTENT_SELECTOR = '[data-stepper-content]';
const PREVIOUS_SELECTOR = '[data-stepper-previous]';
const NEXT_SELECTOR = '[data-stepper-next]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initSteppers(root = document) {
    root.querySelectorAll(STEPPER_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindStepper(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindStepper(root) {
    const linear = root.dataset.linear !== 'false';

    const items = () =>
        Array.from(root.querySelectorAll(ITEM_SELECTOR)).filter(
            (node) => node instanceof HTMLElement && node.dataset.disabled !== 'true',
        );

    const contents = () =>
        Array.from(root.querySelectorAll(CONTENT_SELECTOR)).filter(
            (node) => node instanceof HTMLElement,
        );

    const triggers = () =>
        Array.from(root.querySelectorAll(TRIGGER_SELECTOR)).filter(
            (node) => node instanceof HTMLButtonElement && !node.disabled,
        );

    /**
     * @param {string} value
     */
    const activate = (value) => {
        const enabledItems = items();
        const index = enabledItems.findIndex((item) => item.dataset.value === value);

        if (index < 0) {
            return;
        }

        root.dataset.active = value;

        enabledItems.forEach((item, itemIndex) => {
            let state = 'inactive';

            if (itemIndex < index) {
                state = 'completed';
            } else if (itemIndex === index) {
                state = 'active';
            }

            item.dataset.state = state;
            item.setAttribute('aria-current', state === 'active' ? 'step' : 'false');

            if (item.getAttribute('aria-current') === 'false') {
                item.removeAttribute('aria-current');
            }

            const trigger = item.querySelector(TRIGGER_SELECTOR);

            if (trigger instanceof HTMLButtonElement) {
                trigger.tabIndex = state === 'active' ? 0 : -1;
                trigger.setAttribute('aria-current', state === 'active' ? 'step' : 'false');

                if (trigger.getAttribute('aria-current') === 'false') {
                    trigger.removeAttribute('aria-current');
                }
            }
        });

        // Also sync disabled items that were filtered out of navigation.
        root.querySelectorAll(ITEM_SELECTOR).forEach((item) => {
            if (!(item instanceof HTMLElement) || item.dataset.disabled !== 'true') {
                return;
            }

            if (item.dataset.state === 'active') {
                item.dataset.state = 'inactive';
            }
        });

        contents().forEach((panel) => {
            const selected = panel.dataset.value === value;
            panel.dataset.state = selected ? 'active' : 'inactive';
            panel.hidden = !selected;
            panel.classList.toggle('hidden', !selected);
        });

        const previous = root.querySelector(PREVIOUS_SELECTOR);
        const next = root.querySelector(NEXT_SELECTOR);

        if (previous instanceof HTMLButtonElement) {
            previous.disabled = index <= 0;
            previous.toggleAttribute('disabled', index <= 0);
            previous.setAttribute('aria-disabled', index <= 0 ? 'true' : 'false');
        }

        if (next instanceof HTMLButtonElement) {
            const atEnd = index >= enabledItems.length - 1;
            next.disabled = atEnd;
            next.toggleAttribute('disabled', atEnd);
            next.setAttribute('aria-disabled', atEnd ? 'true' : 'false');
        }

        root.dispatchEvent(
            new CustomEvent('stencil:stepper:change', {
                bubbles: true,
                detail: { value, index },
            }),
        );
    };

    /**
     * @param {number} delta
     */
    const move = (delta) => {
        const enabledItems = items();
        const currentValue = root.dataset.active;
        const currentIndex = enabledItems.findIndex((item) => item.dataset.value === currentValue);
        const nextIndex = currentIndex + delta;

        if (nextIndex < 0 || nextIndex >= enabledItems.length) {
            return;
        }

        const nextValue = enabledItems[nextIndex]?.dataset.value;

        if (typeof nextValue === 'string') {
            activate(nextValue);
            const trigger = enabledItems[nextIndex]?.querySelector(TRIGGER_SELECTOR);

            if (trigger instanceof HTMLButtonElement) {
                trigger.focus();
            }
        }
    };

    const initial =
        root.dataset.active ||
        items().find((item) => item.dataset.state === 'active')?.dataset.value ||
        items()[0]?.dataset.value;

    if (typeof initial === 'string' && initial !== '') {
        activate(initial);
    }

    root.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;

        if (!target) {
            return;
        }

        const previous = target.closest(PREVIOUS_SELECTOR);

        if (previous instanceof HTMLElement && root.contains(previous)) {
            event.preventDefault();
            move(-1);

            return;
        }

        const next = target.closest(NEXT_SELECTOR);

        if (next instanceof HTMLElement && root.contains(next)) {
            event.preventDefault();
            move(1);

            return;
        }

        const trigger =
            target.closest(TRIGGER_SELECTOR) instanceof HTMLButtonElement
                ? target.closest(TRIGGER_SELECTOR)
                : null;

        if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger) || trigger.disabled) {
            return;
        }

        const value = trigger.dataset.value;

        if (typeof value !== 'string') {
            return;
        }

        const enabledItems = items();
        const targetIndex = enabledItems.findIndex((item) => item.dataset.value === value);
        const currentIndex = enabledItems.findIndex(
            (item) => item.dataset.value === root.dataset.active,
        );

        if (linear && targetIndex > currentIndex + 1) {
            return;
        }

        activate(value);
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

        const nextTrigger = enabled[nextIndex];

        if (!(nextTrigger instanceof HTMLButtonElement) || typeof nextTrigger.dataset.value !== 'string') {
            return;
        }

        if (linear) {
            const enabledItems = items();
            const currentIndex = enabledItems.findIndex(
                (item) => item.dataset.value === root.dataset.active,
            );
            const targetIndex = enabledItems.findIndex(
                (item) => item.dataset.value === nextTrigger.dataset.value,
            );

            if (targetIndex > currentIndex + 1) {
                event.preventDefault();
                return;
            }
        }

        event.preventDefault();
        activate(nextTrigger.dataset.value);
        nextTrigger.focus();
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

    initSteppers(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initSteppers());
    } else {
        initSteppers();
    }
}
