/**
 * Stencil — accessible dropdown menu (vanilla JS, no Alpine).
 */

const ROOT_SELECTOR = '[data-dropdown-menu]';
const TRIGGER_SELECTOR = '[data-dropdown-menu-trigger]';
const CONTENT_SELECTOR = '[data-dropdown-menu-content]';
const ITEM_SELECTOR = '[data-dropdown-menu-item]:not([data-disabled="true"])';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initDropdownMenus(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindDropdownMenu(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindDropdownMenu(root) {
    const triggerWrap = root.querySelector(TRIGGER_SELECTOR);
    const content = root.querySelector(CONTENT_SELECTOR);

    if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
    }

    const trigger = resolveTriggerControl(triggerWrap);

    if (!(trigger instanceof HTMLElement)) {
        return;
    }

    let open = false;
    let activeIndex = -1;

    trigger.setAttribute('aria-haspopup', 'menu');
    trigger.setAttribute('aria-expanded', 'false');

    if (!content.id) {
        content.id = `dropdown-menu-${Math.random().toString(36).slice(2, 10)}`;
    }

    trigger.setAttribute('aria-controls', content.id);

    const items = () =>
        Array.from(content.querySelectorAll(ITEM_SELECTOR)).filter(
            (node) => node instanceof HTMLElement,
        );

    /**
     * @param {boolean} nextOpen
     * @param {{ focusIndex?: number | 'last' }} [options]
     */
    const setOpen = (nextOpen, options = {}) => {
        open = nextOpen;
        content.dataset.state = open ? 'open' : 'closed';
        content.hidden = !open;
        content.classList.toggle('hidden', !open);
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

        if (open) {
            positionContent(content, trigger, root);
            const enabled = items();

            if (options.focusIndex === 'last') {
                activeIndex = Math.max(0, enabled.length - 1);
            } else if (typeof options.focusIndex === 'number') {
                activeIndex = options.focusIndex;
            } else {
                activeIndex = 0;
            }

            highlight(enabled, activeIndex);
        } else {
            clearHighlight(items());
            activeIndex = -1;
        }

        root.dispatchEvent(
            new CustomEvent('stencil:dropdown-menu:change', {
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
            setOpen(true, { focusIndex: 0 });

            return;
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();
            setOpen(true, { focusIndex: 'last' });
        }
    });

    content.addEventListener('keydown', (event) => {
        const enabled = items();

        if (event.key === 'ArrowDown') {
            event.preventDefault();
            activeIndex = activeIndex + 1 >= enabled.length ? 0 : activeIndex + 1;
            highlight(enabled, activeIndex);

            return;
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();
            activeIndex = activeIndex - 1 < 0 ? enabled.length - 1 : activeIndex - 1;
            highlight(enabled, activeIndex);

            return;
        }

        if (event.key === 'Home') {
            event.preventDefault();
            activeIndex = 0;
            highlight(enabled, activeIndex);

            return;
        }

        if (event.key === 'End') {
            event.preventDefault();
            activeIndex = enabled.length - 1;
            highlight(enabled, activeIndex);

            return;
        }

        if (event.key === 'Enter' || event.key === ' ') {
            const current = enabled[activeIndex];

            if (current instanceof HTMLElement) {
                event.preventDefault();
                current.click();
            }
        }
    });

    content.addEventListener('click', (event) => {
        const item =
            event.target instanceof Element
                ? event.target.closest('[data-dropdown-menu-item]')
                : null;

        if (!(item instanceof HTMLElement) || !content.contains(item)) {
            return;
        }

        if (item.dataset.disabled === 'true') {
            event.preventDefault();

            return;
        }

        const keepOpen = content.dataset.keepOpen === 'true' || item.dataset.keepOpen === 'true';

        if (!keepOpen) {
            setOpen(false);
            trigger.focus();
        }
    });

    content.addEventListener('mousemove', (event) => {
        const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR) : null;

        if (!(item instanceof HTMLElement)) {
            return;
        }

        const enabled = items();
        activeIndex = enabled.indexOf(item);
        highlight(enabled, activeIndex);
    });

    document.addEventListener('keydown', (event) => {
        if (!open) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            setOpen(false);
            trigger.focus();

            return;
        }

        if (event.key === 'Tab') {
            // APG: Tab closes the menu and continues native tab navigation.
            setOpen(false);
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

        setOpen(false);
    });
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
 * @param {HTMLElement[]} items
 * @param {number} index
 */
function highlight(items, index) {
    items.forEach((item, i) => {
        if (i === index) {
            item.dataset.highlighted = 'true';
            item.focus({ preventScroll: true });
        } else {
            delete item.dataset.highlighted;
        }
    });
}

/**
 * @param {HTMLElement[]} items
 */
function clearHighlight(items) {
    items.forEach((item) => {
        delete item.dataset.highlighted;
    });
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

    if (align === 'end') {
        left = rect.right - width;
    } else if (align === 'center') {
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

    initDropdownMenus(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDropdownMenus());
    } else {
        initDropdownMenus();
    }
}
