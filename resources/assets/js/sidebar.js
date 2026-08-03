/**
 * Stencil — composable app-shell sidebar (vanilla JS, no Alpine).
 * Desktop collapse/expand + mobile overlay; persists open state in localStorage.
 */

import { createBindSignal } from './shared/lifecycle.js';

const PROVIDER_SELECTOR = '[data-sidebar-provider]';
const TRIGGER_SELECTOR = '[data-sidebar-trigger]';
const RAIL_SELECTOR = '[data-sidebar-rail]';
const BACKDROP_SELECTOR = '[data-sidebar-backdrop]';
const ROOT_SELECTOR = '[data-sidebar-root]';
const MOBILE_QUERY = '(max-width: 767px)';
const KEYBOARD_SHORTCUT = 'b';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initSidebars(root = document) {
    root.querySelectorAll(PROVIDER_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindSidebarProvider(element);
    });
}

/**
 * @param {HTMLElement} provider
 */
function bindSidebarProvider(provider) {
    const storageKey = provider.dataset.storageKey || 'stencil-sidebar-state';
    const defaultOpen = provider.dataset.defaultOpen !== 'false';
    const media = window.matchMedia(MOBILE_QUERY);
    const signal = createBindSignal(provider);

    let open = readStoredOpen(storageKey, defaultOpen);
    let openMobile = false;
    let isMobile = media.matches;

    const sync = () => {
        isMobile = media.matches;
        provider.dataset.mobile = isMobile ? 'true' : 'false';
        provider.dataset.mobileOpen = openMobile ? 'true' : 'false';
        provider.dataset.state = open ? 'expanded' : 'collapsed';
        provider.dataset.open = open ? 'true' : 'false';

        const sidebarRoot = provider.querySelector(ROOT_SELECTOR);

        if (sidebarRoot instanceof HTMLElement) {
            const mode = sidebarRoot.dataset.collapsibleMode || 'offcanvas';
            sidebarRoot.dataset.state = open ? 'expanded' : 'collapsed';
            sidebarRoot.dataset.collapsible = open || mode === 'none' ? '' : mode;
            sidebarRoot.dataset.mobile = isMobile ? 'true' : 'false';
            sidebarRoot.dataset.mobileOpen = openMobile ? 'true' : 'false';
        }

        const expandedForControls = isMobile ? openMobile : open;

        provider.querySelectorAll(`${TRIGGER_SELECTOR}, ${RAIL_SELECTOR}`).forEach((node) => {
            if (!(node instanceof HTMLElement)) {
                return;
            }

            const control = resolveControl(node);
            control.setAttribute('aria-expanded', expandedForControls ? 'true' : 'false');
        });

        document.documentElement.classList.toggle(
            'stencil-sidebar-mobile-open',
            isMobile && openMobile,
        );
    };

    /**
     * @param {boolean} next
     */
    const setOpen = (next) => {
        open = next;
        writeStoredOpen(storageKey, open);
        sync();
        provider.dispatchEvent(
            new CustomEvent('stencil:sidebar:change', {
                bubbles: true,
                detail: { open, openMobile, isMobile },
            }),
        );
    };

    /**
     * @param {boolean} next
     */
    const setOpenMobile = (next) => {
        openMobile = next;
        sync();
        provider.dispatchEvent(
            new CustomEvent('stencil:sidebar:change', {
                bubbles: true,
                detail: { open, openMobile, isMobile },
            }),
        );
    };

    const toggle = () => {
        if (isMobile) {
            setOpenMobile(!openMobile);
        } else {
            setOpen(!open);
        }
    };

    provider.addEventListener(
        'click',
        (event) => {
            const target = event.target;

            if (!(target instanceof Element)) {
                return;
            }

            const control = target.closest(
                `${TRIGGER_SELECTOR}, ${RAIL_SELECTOR}, ${BACKDROP_SELECTOR}`,
            );

            if (!(control instanceof HTMLElement) || !provider.contains(control)) {
                return;
            }

            if (control.matches(BACKDROP_SELECTOR)) {
                event.preventDefault();
                setOpenMobile(false);

                return;
            }

            event.preventDefault();
            toggle();
        },
        { signal },
    );

    const onKeydown = (event) => {
        if (event.key === 'Escape' && isMobile && openMobile) {
            event.preventDefault();
            setOpenMobile(false);

            return;
        }

        if (
            event.key.toLowerCase() === KEYBOARD_SHORTCUT &&
            (event.metaKey || event.ctrlKey) &&
            !event.altKey &&
            !event.shiftKey
        ) {
            const tag = event.target instanceof HTMLElement ? event.target.tagName : '';

            if (
                tag === 'INPUT' ||
                tag === 'TEXTAREA' ||
                tag === 'SELECT' ||
                event.target?.isContentEditable
            ) {
                return;
            }

            event.preventDefault();
            toggle();
        }
    };

    document.addEventListener('keydown', onKeydown, { signal });

    const onMediaChange = () => {
        if (!media.matches) {
            openMobile = false;
        }

        sync();
    };

    if (typeof media.addEventListener === 'function') {
        media.addEventListener('change', onMediaChange, { signal });
    } else {
        media.addListener(onMediaChange);
        signal.addEventListener('abort', () => media.removeListener(onMediaChange), { once: true });
    }

    sync();
}

/**
 * @param {HTMLElement} node
 * @returns {HTMLElement}
 */
function resolveControl(node) {
    if (node.matches('button, a[href], [role="button"]')) {
        return node;
    }

    const nested = node.querySelector('button, a[href], [role="button"]');

    return nested instanceof HTMLElement ? nested : node;
}

/**
 * @param {string} key
 * @param {boolean} fallback
 * @returns {boolean}
 */
function readStoredOpen(key, fallback) {
    try {
        const raw = window.localStorage.getItem(key);

        if (raw === null) {
            return fallback;
        }

        return raw === '1' || raw === 'true';
    } catch {
        return fallback;
    }
}

/**
 * @param {string} key
 * @param {boolean} open
 */
function writeStoredOpen(key, open) {
    try {
        window.localStorage.setItem(key, open ? '1' : '0');
    } catch {
        // Ignore quota / private mode failures.
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

    initSidebars(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initSidebars());
    } else {
        initSidebars();
    }
}
