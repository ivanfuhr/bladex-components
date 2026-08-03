/**
 * Reference-counted document scroll lock for floating overlays.
 * Keeps wheel/touch scrolling available inside the allowed roots.
 *
 * Does not set overflow/position on <html>/<body> — those break
 * position:sticky app chrome (common in playbook/app shells).
 */

let lockCount = 0;
/** @type {number} */
let lockedScrollY = 0;

/** @type {Set<() => Element[]>} */
const allowGetters = new Set();

/**
 * @param {Element | Element[] | null | undefined | (() => Element | Element[] | null | undefined)} allowed
 * @returns {() => Element[]}
 */
function toAllowGetter(allowed) {
    if (typeof allowed === 'function') {
        return () => normalizeElements(allowed());
    }

    const snapshot = normalizeElements(allowed);

    return () => snapshot;
}

/**
 * @param {Element | Element[] | null | undefined} value
 * @returns {Element[]}
 */
function normalizeElements(value) {
    if (!value) {
        return [];
    }

    const list = Array.isArray(value) ? value : [value];

    return list.filter((el) => el instanceof Element);
}

/**
 * @param {Event} event
 * @returns {boolean}
 */
function isAllowedTarget(event) {
    const target = event.target;

    if (!(target instanceof Node)) {
        return false;
    }

    for (const getter of allowGetters) {
        for (const root of getter()) {
            if (root.contains(target)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * @param {Event} event
 */
function onScrollAttempt(event) {
    if (isAllowedTarget(event)) {
        return;
    }

    event.preventDefault();
}

function onWindowScroll() {
    if (window.scrollY !== lockedScrollY) {
        window.scrollTo(0, lockedScrollY);
    }
}

/**
 * @param {KeyboardEvent} event
 */
function onKeyScrollAttempt(event) {
    if (isAllowedTarget(event)) {
        return;
    }

    const keys = new Set([
        'ArrowUp',
        'ArrowDown',
        'PageUp',
        'PageDown',
        'Home',
        'End',
        ' ',
        'Spacebar',
    ]);

    if (!keys.has(event.key)) {
        return;
    }

    const target = event.target;

    if (
        target instanceof HTMLElement &&
        (target.isContentEditable ||
            target.matches('input, textarea, select, [role="textbox"], [role="combobox"]'))
    ) {
        return;
    }

    event.preventDefault();
}

function applyLockStyles() {
    lockedScrollY = window.scrollY;

    document.addEventListener('wheel', onScrollAttempt, { passive: false, capture: true });
    document.addEventListener('touchmove', onScrollAttempt, { passive: false, capture: true });
    document.addEventListener('keydown', onKeyScrollAttempt, { capture: true });
    window.addEventListener('scroll', onWindowScroll, { passive: false, capture: true });
}

function clearLockStyles() {
    document.removeEventListener('wheel', onScrollAttempt, { capture: true });
    document.removeEventListener('touchmove', onScrollAttempt, { capture: true });
    document.removeEventListener('keydown', onKeyScrollAttempt, { capture: true });
    window.removeEventListener('scroll', onWindowScroll, { capture: true });

    window.scrollTo(0, lockedScrollY);
}

/**
 * Lock page scroll until the returned release function runs.
 *
 * @param {Element | Element[] | null | undefined | (() => Element | Element[] | null | undefined)} [allowed]
 *        Elements (or a getter) that may still scroll — typically the open panel.
 * @param {{ signal?: AbortSignal }} [options]
 * @returns {() => void}
 */
export function acquireBodyScrollLock(allowed = null, options = {}) {
    const getter = toAllowGetter(allowed);
    allowGetters.add(getter);

    lockCount += 1;

    if (lockCount === 1) {
        applyLockStyles();
    }

    let released = false;

    const release = () => {
        if (released) {
            return;
        }

        released = true;
        allowGetters.delete(getter);
        lockCount = Math.max(0, lockCount - 1);

        if (lockCount === 0) {
            clearLockStyles();
        }
    };

    options.signal?.addEventListener('abort', release, { once: true });

    return release;
}
