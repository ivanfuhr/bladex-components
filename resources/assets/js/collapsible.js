/**
 * Stencil — accessible collapsible panel (vanilla JS, no Alpine).
 */

const COLLAPSIBLE_SELECTOR = '[data-collapsible]';
const TRIGGER_SELECTOR = '[data-collapsible-trigger]';
const CONTENT_SELECTOR = '[data-collapsible-content]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initCollapsibles(root = document) {
    root.querySelectorAll(COLLAPSIBLE_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindCollapsible(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindCollapsible(root) {
    const trigger = root.querySelector(TRIGGER_SELECTOR);
    const content = root.querySelector(CONTENT_SELECTOR);

    if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
    }

    const triggerId = root.dataset.collapsibleTriggerId
        ?? `collapsible-trigger-${Math.random().toString(36).slice(2, 10)}`;
    const contentId = root.dataset.collapsibleContentId
        ?? `collapsible-content-${Math.random().toString(36).slice(2, 10)}`;

    const control = resolveControl(trigger);

    if (control instanceof HTMLElement) {
        if (!control.id) {
            control.id = triggerId;
        }

        control.setAttribute('aria-controls', contentId);
        control.setAttribute('aria-expanded', root.dataset.state === 'open' ? 'true' : 'false');
    }

    if (!content.id) {
        content.id = contentId;
    }

    applyState(root, root.dataset.state === 'open');

    const clickTarget = trigger.matches(TRIGGER_SELECTOR) && trigger.tagName === 'DIV'
        ? trigger
        : control ?? trigger;

    clickTarget.addEventListener('click', (event) => {
        if (root.dataset.collapsibleDisabled === 'true') {
            return;
        }

        if (control instanceof HTMLButtonElement && control.disabled) {
            return;
        }

        event.preventDefault();
        toggle(root);
    });
}

/**
 * @param {HTMLElement} trigger
 * @returns {HTMLElement | null}
 */
function resolveControl(trigger) {
    if (trigger.tagName === 'BUTTON') {
        return trigger;
    }

    const nested = trigger.querySelector('button, [role="button"], a[href]');

    return nested instanceof HTMLElement ? nested : trigger;
}

/**
 * @param {HTMLElement} root
 */
function toggle(root) {
    const open = root.dataset.state !== 'open';
    applyState(root, open);

    root.dispatchEvent(
        new CustomEvent('stencil:collapsible:change', {
            bubbles: true,
            detail: { open },
        }),
    );
}

/**
 * @param {HTMLElement} root
 * @param {boolean} open
 */
function applyState(root, open) {
    const trigger = root.querySelector(TRIGGER_SELECTOR);
    const content = root.querySelector(CONTENT_SELECTOR);
    const transition = root.dataset.collapsibleTransition === 'true';
    const control = trigger instanceof HTMLElement ? resolveControl(trigger) : null;

    root.dataset.state = open ? 'open' : 'closed';

    if (control instanceof HTMLElement) {
        control.setAttribute('aria-expanded', open ? 'true' : 'false');
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
    } else if (open) {
        content.hidden = false;
        content.classList.remove('hidden');
    } else {
        content.hidden = true;
        content.classList.add('hidden');
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

    initCollapsibles(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCollapsibles());
    } else {
        initCollapsibles();
    }
}
