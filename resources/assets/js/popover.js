/**
 * Stencil — accessible popover overlay (vanilla JS, no Alpine).
 */

const ROOT_SELECTOR = '[data-popover]';
const TRIGGER_SELECTOR = '[data-popover-trigger]';
const CONTENT_SELECTOR = '[data-popover-content]';
const FOCUSABLE_SELECTOR =
    'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initPopovers(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        const triggerWrap = element.querySelector(TRIGGER_SELECTOR);
        const content = element.querySelector(CONTENT_SELECTOR);

        if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
            return;
        }

        initialized.add(element);
        bindPopover(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindPopover(root) {
    const triggerWrap = root.querySelector(TRIGGER_SELECTOR);
    const content = root.querySelector(CONTENT_SELECTOR);

    if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
    }

    const trigger = resolveTriggerControl(triggerWrap);

    if (!(trigger instanceof HTMLElement)) {
        return;
    }

    let open = content.dataset.state === 'open' && !content.hidden;

    trigger.setAttribute('aria-haspopup', 'dialog');
    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

    if (!content.id) {
        content.id = `popover-${Math.random().toString(36).slice(2, 10)}`;
    }

    trigger.setAttribute('aria-controls', content.id);

    /**
     * @param {boolean} nextOpen
     * @param {{ restoreFocus?: boolean }} [options]
     */
    const setOpen = (nextOpen, options = {}) => {
        if (open === nextOpen) {
            return;
        }

        open = nextOpen;
        content.dataset.state = open ? 'open' : 'closed';
        content.hidden = !open;
        content.classList.toggle('hidden', !open);
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

        if (open) {
            positionContent(content, trigger, root);
            focusFirstIn(content);
        } else if (options.restoreFocus !== false) {
            trigger.focus({ preventScroll: true });
        }

        root.dispatchEvent(
            new CustomEvent('stencil:popover:change', {
                bubbles: true,
                detail: { open },
            }),
        );
    };

    trigger.addEventListener('click', (event) => {
        event.preventDefault();
        setOpen(!open);
    });

    trigger.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown' || event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            setOpen(true);
        }
    });

    content.addEventListener('click', (event) => {
        const closer =
            event.target instanceof Element ? event.target.closest('[data-popover-close]') : null;

        if (closer instanceof HTMLElement && content.contains(closer)) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (!open) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            setOpen(false);

            return;
        }

        if (event.key === 'Tab') {
            // Non-modal: allow Tab to leave; close when focus exits the popover.
            window.requestAnimationFrame(() => {
                if (!open) {
                    return;
                }

                const active = document.activeElement;

                if (
                    !(active instanceof Node) ||
                    (!root.contains(active) && !content.contains(active))
                ) {
                    setOpen(false, { restoreFocus: false });
                }
            });
        }
    });

    document.addEventListener('pointerdown', (event) => {
        if (!open) {
            return;
        }

        const target = event.target;

        if (!(target instanceof Node)) {
            return;
        }

        if (root.contains(target) || content.contains(target)) {
            return;
        }

        // Nested overlays (select/combobox) portal to body while owned by the popover.
        if (
            target instanceof Element &&
            target.closest(
                '[data-select-portaled], [data-combobox-portaled], [data-color-picker-portaled]',
            )
        ) {
            return;
        }

        setOpen(false, { restoreFocus: false });
    });

    if (open) {
        positionContent(content, trigger, root);
    }
}

/**
 * @param {HTMLElement} wrap
 * @returns {HTMLElement | null}
 */
function resolveTriggerControl(wrap) {
    if (wrap.matches('button, a[href], [role="button"]')) {
        return wrap;
    }

    const nested = wrap.querySelector('button, a[href], [role="button"]');

    return nested instanceof HTMLElement ? nested : wrap;
}

/**
 * @param {HTMLElement} content
 */
function focusFirstIn(content) {
    const first = content.querySelector(FOCUSABLE_SELECTOR);

    if (first instanceof HTMLElement) {
        first.focus({ preventScroll: true });

        return;
    }

    content.focus({ preventScroll: true });
}

/**
 * @param {HTMLElement} content
 * @param {HTMLElement} trigger
 * @param {HTMLElement} root
 */
function positionContent(content, trigger, root) {
    const gap = 6;
    const padding = 8;
    const rect = trigger.getBoundingClientRect();
    const align = root.dataset.align || content.dataset.align || 'start';
    const side = root.dataset.side || content.dataset.side || 'bottom';

    content.style.position = 'fixed';
    content.style.zIndex = '200';
    content.style.minWidth = `${Math.max(rect.width, 10)}px`;

    const wasHidden = content.hidden;
    content.hidden = false;
    content.style.visibility = 'hidden';
    const height = content.offsetHeight;
    const width = content.offsetWidth;
    content.style.visibility = '';
    content.hidden = wasHidden;

    let top = side === 'top' ? rect.top - gap - height : rect.bottom + gap;
    let left = rect.left;

    if (side === 'left') {
        top = rect.top + rect.height / 2 - height / 2;
        left = rect.left - gap - width;
    } else if (side === 'right') {
        top = rect.top + rect.height / 2 - height / 2;
        left = rect.right + gap;
    }

    if (align === 'end' && (side === 'top' || side === 'bottom')) {
        left = rect.right - width;
    } else if (align === 'center' && (side === 'top' || side === 'bottom')) {
        left = rect.left + rect.width / 2 - width / 2;
    }

    left = Math.min(Math.max(padding, left), window.innerWidth - width - padding);
    top = Math.min(Math.max(padding, top), window.innerHeight - height - padding);

    content.style.top = `${top}px`;
    content.style.left = `${left}px`;
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initPopovers(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initPopovers());
    } else {
        initPopovers();
    }
}
