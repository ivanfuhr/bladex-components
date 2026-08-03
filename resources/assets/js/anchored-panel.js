/**
 * Anchored floating panel (portal to body). Shared by select-like overlays and pickers.
 */

/**
 * @param {HTMLElement} panel
 * @param {HTMLElement} trigger
 * @param {{ gap?: number, viewportPadding?: number }} [options]
 */
export function positionAnchoredPanel(panel, trigger, options = {}) {
    const gap = options.gap ?? 6;
    const viewportPadding = options.viewportPadding ?? 8;
    const mediaRoot = trigger.closest('#readme-media');

    // Absolute inside the picker keeps the panel in the #readme-media box for screenshots.
    if (mediaRoot) {
        const anchorRoot =
            trigger.closest(
                '[data-date-picker], [data-time-picker], [data-datetime-picker], [data-color-picker]',
            ) ?? trigger.parentElement;

        if (anchorRoot instanceof HTMLElement) {
            if (getComputedStyle(anchorRoot).position === 'static') {
                anchorRoot.style.position = 'relative';
            }

            const triggerRect = trigger.getBoundingClientRect();
            const rootRect = anchorRoot.getBoundingClientRect();

            panel.style.position = 'absolute';
            panel.style.left = `${Math.max(0, triggerRect.left - rootRect.left)}px`;
            panel.style.top = `${triggerRect.bottom - rootRect.top + gap}px`;
            panel.style.zIndex = '200';
            panel.style.maxHeight = '';

            if (options.fitContent) {
                panel.style.width = 'max-content';
                panel.style.minWidth = '';
            } else {
                panel.style.width = `${Math.max(triggerRect.width, panel.offsetWidth || triggerRect.width)}px`;
                panel.style.minWidth = `${triggerRect.width}px`;
            }

            return;
        }
    }

    const rect = trigger.getBoundingClientRect();

    panel.style.position = 'fixed';
    panel.style.left = `${Math.max(viewportPadding, rect.left)}px`;
    panel.style.zIndex = '200';

    if (options.fitContent) {
        panel.style.width = 'max-content';
        panel.style.minWidth = '';
    } else {
        panel.style.width = `${Math.max(rect.width, panel.offsetWidth || rect.width)}px`;
        panel.style.minWidth = `${rect.width}px`;
    }

    const wasHidden = panel.hidden;
    panel.hidden = false;
    panel.style.visibility = 'hidden';
    panel.style.pointerEvents = 'none';
    const panelHeight = panel.offsetHeight;
    panel.style.visibility = '';
    panel.style.pointerEvents = '';
    panel.hidden = wasHidden;

    let top = rect.bottom + gap;
    const maxBottom = window.innerHeight - viewportPadding;

    if (top + panelHeight > maxBottom) {
        const topAbove = rect.top - gap - panelHeight;

        if (topAbove >= viewportPadding) {
            top = topAbove;
        } else {
            panel.style.maxHeight = `${maxBottom - top}px`;
        }
    } else {
        panel.style.maxHeight = '';
    }

    panel.style.top = `${top}px`;
}

/**
 * @param {HTMLElement} panel
 * @param {HTMLElement} markerParent
 * @param {Comment} portalMarker
 */
export function ensurePanelPortaled(panel, markerParent, portalMarker) {
    // Keep overlays inside the README media canvas so #readme-media screenshots include them.
    if (markerParent?.closest?.('#readme-media') || panel.closest?.('#readme-media')) {
        return;
    }

    if (panel.parentElement === document.body) {
        return;
    }

    if (markerParent && !portalMarker.parentNode) {
        markerParent.insertBefore(portalMarker, panel);
    }

    document.body.appendChild(panel);
    panel.dataset.stencilPortaled = 'true';
}

/**
 * @param {HTMLElement} panel
 * @param {HTMLElement} markerParent
 * @param {Comment} portalMarker
 */
export function restorePanelFromPortal(panel, markerParent, portalMarker) {
    if (panel.parentElement !== document.body) {
        return;
    }

    if (markerParent.isConnected) {
        if (portalMarker.parentNode === markerParent) {
            markerParent.insertBefore(panel, portalMarker.nextSibling);
        } else {
            markerParent.appendChild(panel);
        }
    }

    delete panel.dataset.stencilPortaled;
}

/**
 * @param {HTMLElement} root
 * @param {HTMLElement} panel
 * @param {() => void} onClose
 * @param {AbortSignal} [signal]
 */
export function bindPopoverDismiss(root, panel, onClose, signal) {
    const contains = (target) =>
        target instanceof Node && (root.contains(target) || panel.contains(target));

    /** @type {AddEventListenerOptions} */
    const options = signal ? { signal } : {};

    document.addEventListener(
        'pointerdown',
        (event) => {
            if (!contains(event.target)) {
                onClose();
            }
        },
        options,
    );
}
