/**
 * Stencil — toast / sonner-style notifications (vanilla JS, no Alpine).
 */

const PROVIDER_SELECTOR = '[data-toast-provider]';
const TOAST_SELECTOR = '[data-toast]';
const CLOSE_SELECTOR = '[data-toast-close]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initToasts(root = document) {
    root.querySelectorAll(TOAST_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindToast(element);
    });
}

/**
 * @param {{ title?: string, description?: string, variant?: string, duration?: number }} options
 */
export function toast(options = {}) {
    const provider = document.querySelector(PROVIDER_SELECTOR) ?? createProvider();

    const el = document.createElement('div');
    el.className =
        'toast pointer-events-auto relative w-full rounded-xl border border-zinc-200 bg-white p-4 text-zinc-950 shadow-lg dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50';
    el.dataset.toast = 'true';
    el.dataset.variant = options.variant || 'default';
    el.dataset.duration = String(options.duration ?? 4000);
    el.dataset.state = 'open';
    el.setAttribute('role', 'status');

    const body = document.createElement('div');
    body.className = 'space-y-1 pr-6';

    if (options.title) {
        const title = document.createElement('p');
        title.className = 'toast__title text-sm font-semibold';
        title.dataset.toastTitle = 'true';
        title.textContent = options.title;
        body.appendChild(title);
    }

    if (options.description) {
        const description = document.createElement('p');
        description.className = 'toast__description text-sm opacity-80';
        description.dataset.toastDescription = 'true';
        description.textContent = options.description;
        body.appendChild(description);
    }

    const close = document.createElement('button');
    close.type = 'button';
    close.className =
        'toast__close absolute right-2 top-2 inline-flex size-6 items-center justify-center rounded-md opacity-70 transition hover:opacity-100';
    close.dataset.toastClose = 'true';
    close.setAttribute('aria-label', 'Dismiss');
    close.textContent = '×';

    el.appendChild(body);
    el.appendChild(close);
    provider.appendChild(el);
    initialized.add(el);
    bindToast(el);

    return el;
}

function createProvider() {
    const provider = document.createElement('div');
    provider.className =
        'toast-provider pointer-events-none fixed bottom-4 right-4 z-[400] flex w-full max-w-sm flex-col gap-2 items-end';
    provider.dataset.toastProvider = 'true';
    provider.setAttribute('aria-live', 'polite');
    document.body.appendChild(provider);

    return provider;
}

/**
 * @param {HTMLElement} toastEl
 */
function bindToast(toastEl) {
    const duration = Number.parseInt(toastEl.dataset.duration || '4000', 10);
    /** @type {ReturnType<typeof setTimeout> | null} */
    let timer = null;

    const dismiss = () => {
        window.clearTimeout(timer ?? undefined);
        toastEl.dataset.state = 'closed';
        toastEl.hidden = true;
        toastEl.classList.add('hidden');
        toastEl.dispatchEvent(new CustomEvent('stencil:toast:dismiss', { bubbles: true }));
        window.setTimeout(() => toastEl.remove(), 150);
    };

    toastEl.querySelectorAll(CLOSE_SELECTOR).forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            dismiss();
        });
    });

    if (duration > 0) {
        timer = window.setTimeout(dismiss, duration);
    }
}

if (typeof window !== 'undefined') {
    window.Stencil = window.Stencil ?? {};
    window.Stencil.toast = toast;
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initToasts(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initToasts());
    } else {
        initToasts();
    }
}
