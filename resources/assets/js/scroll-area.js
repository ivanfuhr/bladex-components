/**
 * Stencil — accessible scroll area with themed overlay scrollbars (vanilla JS).
 *
 * Native scrolling (wheel, touch, keyboard) stays on the viewport. Scrollbar
 * chrome is presentational (aria-hidden) and only shims pointer drag/click.
 */

import { createBindSignal } from './shared/lifecycle.js';

const ROOT_SELECTOR = '[data-scroll-area]';
const VIEWPORT_SELECTOR = '[data-scroll-area-viewport]';
const SCROLLBAR_SELECTOR = '[data-scroll-area-scrollbar]';
const THUMB_SELECTOR = '[data-scroll-area-thumb]';
const CORNER_SELECTOR = '[data-scroll-area-corner]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initScrollAreas(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindScrollArea(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindScrollArea(root) {
    const viewport = root.querySelector(VIEWPORT_SELECTOR);

    if (!(viewport instanceof HTMLElement)) {
        return;
    }

    const signal = createBindSignal(root);
    const type = root.dataset.scrollAreaType || 'hover';
    const hideDelay = Number.parseInt(root.dataset.scrollAreaHideDelay || '600', 10);
    const scrollbars = Array.from(root.querySelectorAll(SCROLLBAR_SELECTOR)).filter(
        (node) => node instanceof HTMLElement,
    );
    const corner = root.querySelector(CORNER_SELECTOR);

    /** @type {ReturnType<typeof setTimeout> | null} */
    let hideTimer = null;
    let scrolling = false;
    let pointerInside = false;

    /**
     * @param {HTMLElement} scrollbar
     */
    const thumbFor = (scrollbar) => {
        const thumb = scrollbar.querySelector(THUMB_SELECTOR);

        return thumb instanceof HTMLElement ? thumb : null;
    };

    const isScrollable = (orientation) => {
        if (orientation === 'horizontal') {
            return viewport.scrollWidth - viewport.clientWidth > 1;
        }

        return viewport.scrollHeight - viewport.clientHeight > 1;
    };

    /**
     * @param {'visible' | 'hidden'} state
     */
    const setChromeState = (state) => {
        for (const scrollbar of scrollbars) {
            const orientation =
                scrollbar.dataset.orientation === 'horizontal' ? 'horizontal' : 'vertical';
            const next = state === 'visible' && isScrollable(orientation) ? 'visible' : 'hidden';
            scrollbar.dataset.state = next;

            const thumb = thumbFor(scrollbar);

            if (thumb) {
                thumb.dataset.state = next;
            }
        }

        if (corner instanceof HTMLElement) {
            const verticalVisible = scrollbars.some(
                (bar) =>
                    bar.dataset.orientation !== 'horizontal' && bar.dataset.state === 'visible',
            );
            const horizontalVisible = scrollbars.some(
                (bar) =>
                    bar.dataset.orientation === 'horizontal' && bar.dataset.state === 'visible',
            );
            corner.dataset.state = verticalVisible && horizontalVisible ? 'visible' : 'hidden';
        }
    };

    const showChrome = () => {
        if (hideTimer !== null) {
            clearTimeout(hideTimer);
            hideTimer = null;
        }

        setChromeState('visible');
    };

    const scheduleHide = () => {
        if (type === 'always') {
            setChromeState('visible');

            return;
        }

        if (pointerInside && (type === 'hover' || type === 'auto')) {
            return;
        }

        if (hideTimer !== null) {
            clearTimeout(hideTimer);
        }

        hideTimer = setTimeout(
            () => {
                hideTimer = null;

                if (!scrolling && !(pointerInside && (type === 'hover' || type === 'auto'))) {
                    setChromeState('hidden');
                }
            },
            Number.isFinite(hideDelay) ? hideDelay : 600,
        );
    };

    const updateThumbs = () => {
        for (const scrollbar of scrollbars) {
            const orientation =
                scrollbar.dataset.orientation === 'horizontal' ? 'horizontal' : 'vertical';
            const thumb = thumbFor(scrollbar);

            if (!thumb) {
                continue;
            }

            if (!isScrollable(orientation)) {
                scrollbar.dataset.state = 'hidden';
                thumb.dataset.state = 'hidden';
                continue;
            }

            if (orientation === 'vertical') {
                const trackSize = scrollbar.clientHeight;
                const ratio = viewport.clientHeight / viewport.scrollHeight;
                const thumbSize = Math.max(16, Math.floor(trackSize * ratio));
                const maxScroll = viewport.scrollHeight - viewport.clientHeight;
                const maxOffset = Math.max(0, trackSize - thumbSize);
                const offset = maxScroll > 0 ? (viewport.scrollTop / maxScroll) * maxOffset : 0;

                thumb.style.height = `${thumbSize}px`;
                thumb.style.width = '';
                thumb.style.transform = `translate3d(0, ${offset}px, 0)`;
            } else {
                const trackSize = scrollbar.clientWidth;
                const ratio = viewport.clientWidth / viewport.scrollWidth;
                const thumbSize = Math.max(16, Math.floor(trackSize * ratio));
                const maxScroll = viewport.scrollWidth - viewport.clientWidth;
                const maxOffset = Math.max(0, trackSize - thumbSize);
                const offset = maxScroll > 0 ? (viewport.scrollLeft / maxScroll) * maxOffset : 0;

                thumb.style.width = `${thumbSize}px`;
                thumb.style.height = '';
                thumb.style.transform = `translate3d(${offset}px, 0, 0)`;
            }
        }

        if (type === 'always') {
            setChromeState('visible');
        } else if (corner instanceof HTMLElement) {
            const verticalVisible = scrollbars.some(
                (bar) =>
                    bar.dataset.orientation !== 'horizontal' && bar.dataset.state === 'visible',
            );
            const horizontalVisible = scrollbars.some(
                (bar) =>
                    bar.dataset.orientation === 'horizontal' && bar.dataset.state === 'visible',
            );
            corner.dataset.state = verticalVisible && horizontalVisible ? 'visible' : 'hidden';
        }
    };

    const onScroll = () => {
        updateThumbs();

        if (type === 'always') {
            return;
        }

        scrolling = true;
        showChrome();

        if (hideTimer !== null) {
            clearTimeout(hideTimer);
        }

        hideTimer = setTimeout(
            () => {
                scrolling = false;
                hideTimer = null;
                scheduleHide();
            },
            Number.isFinite(hideDelay) ? hideDelay : 600,
        );
    };

    viewport.addEventListener('scroll', onScroll, { passive: true, signal });

    // Textarea scrollHeight changes on input without resizing the element.
    if (viewport instanceof HTMLTextAreaElement) {
        viewport.addEventListener('input', updateThumbs, { signal });
    }

    root.addEventListener(
        'pointerenter',
        () => {
            pointerInside = true;

            if (type === 'hover' || type === 'auto' || type === 'always') {
                updateThumbs();
                showChrome();
            }
        },
        { signal },
    );

    root.addEventListener(
        'pointerleave',
        () => {
            pointerInside = false;
            scheduleHide();
        },
        { signal },
    );

    /**
     * @param {HTMLElement} scrollbar
     */
    const bindScrollbarPointer = (scrollbar) => {
        const orientation =
            scrollbar.dataset.orientation === 'horizontal' ? 'horizontal' : 'vertical';
        const thumb = thumbFor(scrollbar);

        if (!thumb) {
            return;
        }

        /** @type {{ pointerId: number, startPos: number, startScroll: number } | null} */
        let drag = null;

        const onPointerMove = (event) => {
            if (!drag || event.pointerId !== drag.pointerId) {
                return;
            }

            if (orientation === 'vertical') {
                const trackSize = scrollbar.clientHeight;
                const thumbSize = thumb.offsetHeight;
                const maxOffset = Math.max(0, trackSize - thumbSize);
                const maxScroll = viewport.scrollHeight - viewport.clientHeight;
                const delta = event.clientY - drag.startPos;
                const nextOffset = Math.min(maxOffset, Math.max(0, drag.startScroll + delta));
                viewport.scrollTop = maxOffset > 0 ? (nextOffset / maxOffset) * maxScroll : 0;
            } else {
                const trackSize = scrollbar.clientWidth;
                const thumbSize = thumb.offsetWidth;
                const maxOffset = Math.max(0, trackSize - thumbSize);
                const maxScroll = viewport.scrollWidth - viewport.clientWidth;
                const delta = event.clientX - drag.startPos;
                const nextOffset = Math.min(maxOffset, Math.max(0, drag.startScroll + delta));
                viewport.scrollLeft = maxOffset > 0 ? (nextOffset / maxOffset) * maxScroll : 0;
            }
        };

        const endDrag = (event) => {
            if (!drag || event.pointerId !== drag.pointerId) {
                return;
            }

            drag = null;
            thumb.releasePointerCapture?.(event.pointerId);
            document.removeEventListener('pointermove', onPointerMove);
            document.removeEventListener('pointerup', endDrag);
            document.removeEventListener('pointercancel', endDrag);
            scheduleHide();
        };

        thumb.addEventListener(
            'pointerdown',
            (event) => {
                if (event.button !== 0 || !(event instanceof PointerEvent)) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                const startPos = orientation === 'vertical' ? event.clientY : event.clientX;
                const startScroll =
                    orientation === 'vertical'
                        ? (() => {
                              const trackSize = scrollbar.clientHeight;
                              const thumbSize = thumb.offsetHeight;
                              const maxOffset = Math.max(0, trackSize - thumbSize);
                              const maxScroll = viewport.scrollHeight - viewport.clientHeight;

                              return maxScroll > 0
                                  ? (viewport.scrollTop / maxScroll) * maxOffset
                                  : 0;
                          })()
                        : (() => {
                              const trackSize = scrollbar.clientWidth;
                              const thumbSize = thumb.offsetWidth;
                              const maxOffset = Math.max(0, trackSize - thumbSize);
                              const maxScroll = viewport.scrollWidth - viewport.clientWidth;

                              return maxScroll > 0
                                  ? (viewport.scrollLeft / maxScroll) * maxOffset
                                  : 0;
                          })();

                drag = {
                    pointerId: event.pointerId,
                    startPos,
                    startScroll,
                };

                thumb.setPointerCapture?.(event.pointerId);
                document.addEventListener('pointermove', onPointerMove, { signal });
                document.addEventListener('pointerup', endDrag, { signal });
                document.addEventListener('pointercancel', endDrag, { signal });
                showChrome();
            },
            { signal },
        );

        scrollbar.addEventListener(
            'pointerdown',
            (event) => {
                if (
                    event.button !== 0 ||
                    event.target === thumb ||
                    thumb.contains(/** @type {Node} */ (event.target))
                ) {
                    return;
                }

                event.preventDefault();

                const rect = scrollbar.getBoundingClientRect();

                if (orientation === 'vertical') {
                    const thumbSize = thumb.offsetHeight;
                    const clickOffset = event.clientY - rect.top - thumbSize / 2;
                    const maxOffset = Math.max(0, scrollbar.clientHeight - thumbSize);
                    const maxScroll = viewport.scrollHeight - viewport.clientHeight;
                    viewport.scrollTop =
                        maxOffset > 0
                            ? (Math.min(maxOffset, Math.max(0, clickOffset)) / maxOffset) *
                              maxScroll
                            : 0;
                } else {
                    const thumbSize = thumb.offsetWidth;
                    const clickOffset = event.clientX - rect.left - thumbSize / 2;
                    const maxOffset = Math.max(0, scrollbar.clientWidth - thumbSize);
                    const maxScroll = viewport.scrollWidth - viewport.clientWidth;
                    viewport.scrollLeft =
                        maxOffset > 0
                            ? (Math.min(maxOffset, Math.max(0, clickOffset)) / maxOffset) *
                              maxScroll
                            : 0;
                }

                showChrome();
            },
            { signal },
        );
    };

    for (const scrollbar of scrollbars) {
        bindScrollbarPointer(scrollbar);
    }

    const resizeObserver = new ResizeObserver(() => {
        updateThumbs();

        if (type === 'always') {
            setChromeState('visible');
        }
    });

    resizeObserver.observe(viewport);

    const content = viewport.querySelector('[data-scroll-area-content]');

    if (content instanceof HTMLElement) {
        resizeObserver.observe(content);
    }

    signal.addEventListener(
        'abort',
        () => {
            resizeObserver.disconnect();

            if (hideTimer !== null) {
                clearTimeout(hideTimer);
            }
        },
        { once: true },
    );

    updateThumbs();

    if (type === 'always') {
        setChromeState('visible');
    } else {
        setChromeState('hidden');
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

    initScrollAreas(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initScrollAreas());
    } else {
        initScrollAreas();
    }
}
