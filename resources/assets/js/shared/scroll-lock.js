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
 * @typedef {{
 *   scrollTop: number,
 *   scrollLeft: number,
 *   overflow: string,
 *   overscrollBehavior: string,
 *   touchAction: string,
 * }} LockedScrollState
 */

/** @type {Map<HTMLElement, LockedScrollState>} */
const lockedScrollContainers = new Map();

/** @type {Map<HTMLElement, string>} */
const lockedScrollAreaRoots = new Map();

/** @type {number | null} */
let lockFrame = null;

const SCROLL_AREA_VIEWPORT_SELECTOR = '[data-scroll-area-viewport]';

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

    return isInsideAllowedRoots(target);
}

/**
 * @param {Node} node
 * @returns {boolean}
 */
function isInsideAllowedRoots(node) {
    for (const getter of allowGetters) {
        for (const root of getter()) {
            if (root.contains(node)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * @param {HTMLElement} container
 * @returns {LockedScrollState}
 */
function snapshotScrollState(container) {
    return {
        scrollTop: container.scrollTop,
        scrollLeft: container.scrollLeft,
        overflow: container.style.overflow,
        overscrollBehavior: container.style.overscrollBehavior,
        touchAction: container.style.touchAction,
    };
}

/**
 * @param {HTMLElement} container
 * @param {LockedScrollState} saved
 */
function restoreScrollPosition(container, saved) {
    if (container.scrollTop !== saved.scrollTop) {
        container.scrollTop = saved.scrollTop;
    }

    if (container.scrollLeft !== saved.scrollLeft) {
        container.scrollLeft = saved.scrollLeft;
    }
}

/**
 * @param {HTMLElement} container
 */
function lockScrollContainer(container) {
    if (lockedScrollContainers.has(container)) {
        return;
    }

    const saved = snapshotScrollState(container);
    lockedScrollContainers.set(container, saved);

    container.dataset.stencilScrollLocked = 'true';
    container.style.overflow = 'hidden';
    container.style.overscrollBehavior = 'none';
    container.style.touchAction = 'none';

    const scrollArea = container.closest('[data-scroll-area]');

    if (scrollArea instanceof HTMLElement && !lockedScrollAreaRoots.has(scrollArea)) {
        lockedScrollAreaRoots.set(scrollArea, scrollArea.dataset.stencilScrollLocked ?? '');
        scrollArea.dataset.stencilScrollLocked = 'true';
    }

    container.addEventListener('scroll', onLockedContainerScroll, { passive: false, capture: true });
    container.addEventListener('wheel', onLockedContainerWheel, { passive: false, capture: true });
}

/**
 * @param {HTMLElement} container
 */
function unlockScrollContainer(container) {
    const saved = lockedScrollContainers.get(container);

    if (!saved) {
        return;
    }

    container.removeEventListener('scroll', onLockedContainerScroll, { capture: true });
    container.removeEventListener('wheel', onLockedContainerWheel, { capture: true });

    container.style.overflow = saved.overflow;
    container.style.overscrollBehavior = saved.overscrollBehavior;
    container.style.touchAction = saved.touchAction;
    container.scrollTop = saved.scrollTop;
    container.scrollLeft = saved.scrollLeft;
    delete container.dataset.stencilScrollLocked;
    lockedScrollContainers.delete(container);

    const scrollArea = container.closest('[data-scroll-area]');

    if (scrollArea instanceof HTMLElement && lockedScrollAreaRoots.has(scrollArea)) {
        const previous = lockedScrollAreaRoots.get(scrollArea) ?? '';

        if (previous) {
            scrollArea.dataset.stencilScrollLocked = previous;
        } else {
            delete scrollArea.dataset.stencilScrollLocked;
        }

        lockedScrollAreaRoots.delete(scrollArea);
    }
}

/**
 * @param {Event} event
 */
function onLockedContainerScroll(event) {
    const container = event.currentTarget;

    if (!(container instanceof HTMLElement)) {
        return;
    }

    const saved = lockedScrollContainers.get(container);

    if (!saved) {
        return;
    }

    restoreScrollPosition(container, saved);
}

/**
 * @param {WheelEvent} event
 */
function onLockedContainerWheel(event) {
    event.preventDefault();
    event.stopPropagation();
}

function startLockFrame() {
    if (lockFrame !== null) {
        return;
    }

    const tick = () => {
        for (const [container, saved] of lockedScrollContainers) {
            restoreScrollPosition(container, saved);
        }

        lockFrame = requestAnimationFrame(tick);
    };

    lockFrame = requestAnimationFrame(tick);
}

function stopLockFrame() {
    if (lockFrame === null) {
        return;
    }

    cancelAnimationFrame(lockFrame);
    lockFrame = null;
}

function syncNestedScrollAreas() {
    if (lockCount === 0) {
        stopLockFrame();

        for (const container of [...lockedScrollContainers.keys()]) {
            unlockScrollContainer(container);
        }

        return;
    }

    document.querySelectorAll(SCROLL_AREA_VIEWPORT_SELECTOR).forEach((node) => {
        if (!(node instanceof HTMLElement)) {
            return;
        }

        if (isInsideAllowedRoots(node)) {
            unlockScrollContainer(node);

            return;
        }

        lockScrollContainer(node);
    });

    startLockFrame();
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

    syncNestedScrollAreas();

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

        syncNestedScrollAreas();
    };

    options.signal?.addEventListener('abort', release, { once: true });

    return release;
}
