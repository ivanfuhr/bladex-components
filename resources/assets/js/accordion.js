/**
 * Stencil — accessible accordion (vanilla JS, no Alpine).
 */

const ACCORDION_SELECTOR = '[data-accordion]';
const ITEM_SELECTOR = '[data-accordion-item]';
const TRIGGER_SELECTOR = '[data-accordion-trigger]';
const CONTENT_SELECTOR = '[data-accordion-content]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initAccordions(root = document) {
    root.querySelectorAll(ACCORDION_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindAccordion(element);
    });
}

/**
 * @param {HTMLElement} accordion
 */
function bindAccordion(accordion) {
    syncItemWiring(accordion);

    const triggers = () =>
        Array.from(accordion.querySelectorAll(TRIGGER_SELECTOR)).filter(
            (node) => node instanceof HTMLButtonElement && !node.disabled,
        );

    accordion.addEventListener('keydown', (event) => {
        const trigger =
            event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR) : null;

        if (!(trigger instanceof HTMLButtonElement) || !accordion.contains(trigger)) {
            return;
        }

        const enabled = triggers();
        const index = enabled.indexOf(trigger);

        if (index < 0) {
            return;
        }

        let nextIndex = index;

        if (event.key === 'ArrowDown') {
            nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
        } else if (event.key === 'ArrowUp') {
            nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
        } else if (event.key === 'Home') {
            nextIndex = 0;
        } else if (event.key === 'End') {
            nextIndex = enabled.length - 1;
        } else {
            return;
        }

        event.preventDefault();
        enabled[nextIndex]?.focus();
    });

    accordion.addEventListener('click', (event) => {
        const trigger =
            event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR) : null;

        if (!(trigger instanceof HTMLButtonElement) || !accordion.contains(trigger)) {
            return;
        }

        if (trigger.disabled) {
            return;
        }

        const item = trigger.closest(ITEM_SELECTOR);

        if (!(item instanceof HTMLElement) || item.dataset.accordionDisabled === 'true') {
            return;
        }

        event.preventDefault();
        toggleItem(accordion, item);
    });
}

/**
 * @param {HTMLElement} accordion
 */
function syncItemWiring(accordion) {
    accordion.querySelectorAll(ITEM_SELECTOR).forEach((item) => {
        if (!(item instanceof HTMLElement)) {
            return;
        }

        const trigger = item.querySelector(TRIGGER_SELECTOR);
        const content = item.querySelector(CONTENT_SELECTOR);

        if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
            return;
        }

        if (!trigger.id) {
            trigger.id = `accordion-trigger-${Math.random().toString(36).slice(2, 10)}`;
        }

        if (!content.id) {
            content.id = `accordion-content-${Math.random().toString(36).slice(2, 10)}`;
        }

        trigger.setAttribute('aria-controls', content.id);
        content.setAttribute('aria-labelledby', trigger.id);
        content.setAttribute('role', 'region');

        applyItemState(item, item.dataset.state === 'open');
    });
}

/**
 * @param {HTMLElement} accordion
 * @param {HTMLElement} item
 */
function toggleItem(accordion, item) {
    const willOpen = item.dataset.state !== 'open';
    const exclusive = accordion.dataset.accordionExclusive === 'true';

    if (willOpen && exclusive) {
        accordion.querySelectorAll(ITEM_SELECTOR).forEach((other) => {
            if (other instanceof HTMLElement && other !== item) {
                applyItemState(other, false);
            }
        });
    }

    applyItemState(item, willOpen);

    accordion.dispatchEvent(
        new CustomEvent('stencil:accordion:change', {
            bubbles: true,
            detail: {
                value: item.dataset.accordionValue ?? null,
                open: willOpen,
            },
        }),
    );
}

/**
 * @param {HTMLElement} item
 * @param {boolean} open
 */
function applyItemState(item, open) {
    const trigger = item.querySelector(TRIGGER_SELECTOR);
    const content = item.querySelector(CONTENT_SELECTOR);
    const accordion = item.closest(ACCORDION_SELECTOR);
    const transition =
        accordion instanceof HTMLElement && accordion.dataset.accordionTransition === 'true';

    item.dataset.state = open ? 'open' : 'closed';

    if (trigger instanceof HTMLElement) {
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    if (!(content instanceof HTMLElement)) {
        return;
    }

    content.dataset.state = open ? 'open' : 'closed';

    if (transition) {
        content.classList.toggle('grid-rows-[1fr]', open);
        content.classList.toggle('opacity-100', open);
        content.classList.toggle('grid-rows-[0fr]', !open);
        content.classList.toggle('opacity-0', !open);
        content.classList.remove('hidden');
        content.hidden = false;

        if (open) {
            content.removeAttribute('inert');
            content.removeAttribute('aria-hidden');
        } else {
            content.setAttribute('inert', '');
            content.setAttribute('aria-hidden', 'true');
        }
    } else if (open) {
        content.hidden = false;
        content.classList.remove('hidden');
        content.removeAttribute('inert');
        content.removeAttribute('aria-hidden');
    } else {
        content.hidden = true;
        content.classList.add('hidden');
        content.removeAttribute('inert');
        content.removeAttribute('aria-hidden');
    }
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initAccordions(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initAccordions());
    } else {
        initAccordions();
    }
}
