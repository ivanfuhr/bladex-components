/**
 * Stencil — accessible tooltips (vanilla JS, no Alpine).
 */

const ROOT_SELECTOR = '[data-tooltip]';
const TRIGGER_SELECTOR = '[data-tooltip-trigger]';
const CONTENT_SELECTOR = '[data-tooltip-content]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initTooltips(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindTooltip(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindTooltip(root) {
    const trigger = root.querySelector(TRIGGER_SELECTOR);
    const content = root.querySelector(CONTENT_SELECTOR);

    if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
    }

    const delay = Number.parseInt(root.dataset.delay || '200', 10) || 200;
    /** @type {ReturnType<typeof setTimeout> | null} */
    let showTimer = null;
    let open = false;

    if (!content.id) {
        content.id = `tooltip-${Math.random().toString(36).slice(2, 10)}`;
    }

    const control = trigger.querySelector('button, a, [tabindex]') ?? trigger;
    control.setAttribute('aria-describedby', content.id);

    const setOpen = (next) => {
        open = next;

        if (open) {
            // Mark open + take out of flow before measuring so an in-flow
            // tooltip does not shift the trigger (e.g. header actions on the right).
            content.dataset.state = 'open';
            positionTooltip(content, trigger, root.dataset.side || content.dataset.side || 'top');
            content.hidden = false;
            content.classList.remove('hidden');
            content.style.visibility = '';
        } else {
            content.dataset.state = 'closed';
            content.hidden = true;
            content.classList.add('hidden');
            content.style.position = '';
            content.style.top = '';
            content.style.left = '';
            content.style.visibility = '';
            content.style.zIndex = '';
        }
    };

    const scheduleOpen = () => {
        if (isSidebarMenuTooltipDisabled(root)) {
            return;
        }

        window.clearTimeout(showTimer ?? undefined);
        showTimer = window.setTimeout(() => setOpen(true), delay);
    };

    const close = () => {
        window.clearTimeout(showTimer ?? undefined);
        setOpen(false);
    };

    trigger.addEventListener('pointerenter', scheduleOpen);
    trigger.addEventListener('pointerleave', close);
    control.addEventListener('focus', () => {
        if (isSidebarMenuTooltipDisabled(root)) {
            return;
        }

        setOpen(true);
    });
    control.addEventListener('blur', close);
    root.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
}

/**
 * Sidebar menu tooltips only appear in icon-collapsed desktop mode.
 *
 * @param {HTMLElement} root
 */
function isSidebarMenuTooltipDisabled(root) {
    if (! root.hasAttribute('data-sidebar-menu-tooltip')) {
        return false;
    }

    const sidebarRoot = root.closest('[data-sidebar-root]');

    if (!(sidebarRoot instanceof HTMLElement)) {
        return true;
    }

    return sidebarRoot.dataset.collapsible !== 'icon' || sidebarRoot.dataset.mobile === 'true';
}

/**
 * @param {HTMLElement} content
 * @param {HTMLElement} trigger
 * @param {string} side
 */
function positionTooltip(content, trigger, side) {
    const gap = 6;
    const padding = 8;
    const rect = trigger.getBoundingClientRect();

    content.style.position = 'fixed';
    content.style.zIndex = '300';
    content.style.visibility = 'hidden';
    content.hidden = false;
    content.classList.remove('hidden');

    const width = content.offsetWidth;
    const height = content.offsetHeight;

    let top = rect.top;
    let left = rect.left + rect.width / 2 - width / 2;

    if (side === 'bottom') {
        top = rect.bottom + gap;
    } else if (side === 'left') {
        top = rect.top + rect.height / 2 - height / 2;
        left = rect.left - gap - width;
    } else if (side === 'right') {
        top = rect.top + rect.height / 2 - height / 2;
        left = rect.right + gap;
    } else {
        top = rect.top - gap - height;
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

    initTooltips(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initTooltips());
    } else {
        initTooltips();
    }
}
