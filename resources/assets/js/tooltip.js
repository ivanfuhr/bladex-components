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
        content.dataset.state = open ? 'open' : 'closed';
        content.hidden = !open;
        content.classList.toggle('hidden', !open);

        if (open) {
            positionTooltip(content, trigger, root.dataset.side || content.dataset.side || 'top');
        }
    };

    const scheduleOpen = () => {
        window.clearTimeout(showTimer ?? undefined);
        showTimer = window.setTimeout(() => setOpen(true), delay);
    };

    const close = () => {
        window.clearTimeout(showTimer ?? undefined);
        setOpen(false);
    };

    trigger.addEventListener('pointerenter', scheduleOpen);
    trigger.addEventListener('pointerleave', close);
    control.addEventListener('focus', () => setOpen(true));
    control.addEventListener('blur', close);
    root.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
}

/**
 * @param {HTMLElement} content
 * @param {HTMLElement} trigger
 * @param {string} side
 */
function positionTooltip(content, trigger, side) {
    const gap = 6;
    const rect = trigger.getBoundingClientRect();

    content.style.position = 'fixed';
    content.style.zIndex = '300';

    const wasHidden = content.hidden;
    content.hidden = false;
    content.style.visibility = 'hidden';
    const width = content.offsetWidth;
    const height = content.offsetHeight;
    content.style.visibility = '';
    content.hidden = wasHidden;

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

    content.style.top = `${Math.max(4, top)}px`;
    content.style.left = `${Math.max(4, left)}px`;
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
