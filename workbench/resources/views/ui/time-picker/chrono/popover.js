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
 */
export function bindPopoverDismiss(root, panel, onClose) {
    const contains = (target) =>
        target instanceof Node && (root.contains(target) || panel.contains(target));

    document.addEventListener('pointerdown', (event) => {
        if (!contains(event.target)) {
            onClose();
        }
    });

    window.addEventListener(
        'scroll',
        () => {
            onClose();
        },
        true,
    );
}
