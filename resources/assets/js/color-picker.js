/**
 * Std Components — color picker with SV canvas, hue slider, and swatch palette (vanilla JS).
 */

import { createBindSignal } from './shared/lifecycle.js';
import { acquireBodyScrollLock } from './shared/scroll-lock.js';

const COLOR_PICKER_SELECTOR = '[data-color-picker]';
const FOCUSABLE_SELECTOR =
    'button:not([disabled]):not([hidden]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
const initialized = new WeakSet();
const HEX_PATTERN = /^#[0-9a-fA-F]{6}$/;

/**
 * @param {ParentNode} root
 */
export function initColorPickers(root = document) {
    document
        .querySelectorAll('[data-color-picker-popover][data-color-picker-portaled]')
        .forEach((popover) => {
            if (!(popover instanceof HTMLElement) || popover.closest('[data-color-picker]')) {
                return;
            }

            popover.remove();
        });

    root.querySelectorAll(COLOR_PICKER_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindColorPicker(element);
    });
}

/**
 * @param {string} hex
 * @returns {{ r: number, g: number, b: number }}
 */
function hexToRgb(hex) {
    const normalized = hex.replace('#', '');
    const value = Number.parseInt(normalized, 16);

    return {
        r: (value >> 16) & 255,
        g: (value >> 8) & 255,
        b: value & 255,
    };
}

/**
 * @param {number} r
 * @param {number} g
 * @param {number} b
 * @returns {string}
 */
function rgbToHex(r, g, b) {
    const toHex = (channel) => channel.toString(16).padStart(2, '0');

    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}

/**
 * @param {number} r
 * @param {number} g
 * @param {number} b
 * @returns {{ h: number, s: number, v: number }}
 */
function rgbToHsv(r, g, b) {
    const red = r / 255;
    const green = g / 255;
    const blue = b / 255;
    const max = Math.max(red, green, blue);
    const min = Math.min(red, green, blue);
    const delta = max - min;

    let hue = 0;

    if (delta !== 0) {
        if (max === red) {
            hue = ((green - blue) / delta) % 6;
        } else if (max === green) {
            hue = (blue - red) / delta + 2;
        } else {
            hue = (red - green) / delta + 4;
        }
    }

    hue = Math.round(hue * 60);

    if (hue < 0) {
        hue += 360;
    }

    const saturation = max === 0 ? 0 : (delta / max) * 100;
    const value = max * 100;

    return { h: hue, s: saturation, v: value };
}

/**
 * @param {number} h
 * @param {number} s
 * @param {number} v
 * @returns {{ r: number, g: number, b: number }}
 */
function hsvToRgb(h, s, v) {
    const saturation = s / 100;
    const value = v / 100;
    const chroma = value * saturation;
    const segment = (h / 60) % 6;
    const x = chroma * (1 - Math.abs((segment % 2) - 1));
    const m = value - chroma;

    let red = 0;
    let green = 0;
    let blue = 0;

    if (segment >= 0 && segment < 1) {
        red = chroma;
        green = x;
    } else if (segment >= 1 && segment < 2) {
        red = x;
        green = chroma;
    } else if (segment >= 2 && segment < 3) {
        green = chroma;
        blue = x;
    } else if (segment >= 3 && segment < 4) {
        green = x;
        blue = chroma;
    } else if (segment >= 4 && segment < 5) {
        red = x;
        blue = chroma;
    } else {
        red = chroma;
        blue = x;
    }

    return {
        r: Math.round((red + m) * 255),
        g: Math.round((green + m) * 255),
        b: Math.round((blue + m) * 255),
    };
}

/**
 * @param {number} h
 * @param {number} s
 * @param {number} v
 * @returns {string}
 */
function hsvToHex(h, s, v) {
    const { r, g, b } = hsvToRgb(h, s, v);

    return rgbToHex(r, g, b);
}

/**
 * @param {string} raw
 * @returns {string | null}
 */
function parseHexInput(raw) {
    let value = raw.trim();

    if (value === '') {
        return null;
    }

    if (!value.startsWith('#')) {
        value = `#${value}`;
    }

    if (/^#[0-9a-fA-F]{3}$/.test(value)) {
        const [, r, g, b] = value.match(/^#(.)(.)(.)$/) ?? [];

        if (r && g && b) {
            return `#${r}${r}${g}${g}${b}${b}`.toLowerCase();
        }
    }

    if (HEX_PATTERN.test(value)) {
        return value.toLowerCase();
    }

    return null;
}

/**
 * @param {HTMLElement} container
 * @returns {HTMLElement[]}
 */
function getFocusableElements(container) {
    return Array.from(container.querySelectorAll(FOCUSABLE_SELECTOR)).filter(
        (node) => node instanceof HTMLElement && !node.hasAttribute('hidden'),
    );
}

/**
 * @param {HTMLElement} container
 */
function focusFirstIn(container) {
    const first = getFocusableElements(container)[0];

    if (first instanceof HTMLElement) {
        first.focus({ preventScroll: true });
    }
}

/**
 * @param {KeyboardEvent} event
 * @param {HTMLElement} container
 */
function trapFocus(event, container) {
    const focusable = getFocusableElements(container);

    if (focusable.length === 0) {
        return;
    }

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
}

/**
 * @param {HTMLElement} root
 */
function bindColorPicker(root) {
    /** @type {HTMLInputElement | null} */
    const hiddenInput = root.querySelector('[data-color-picker-hidden-input]');
    /** @type {HTMLInputElement | null} */
    const hexInput = root.querySelector('[data-color-picker-hex]');
    const swatchTrigger = root.querySelector('[data-color-picker-swatch-trigger]');
    const trigger = root.querySelector('[data-color-picker-trigger]');
    const popover = root.querySelector('[data-color-picker-popover]');
    const area = root.querySelector('[data-color-picker-area]');
    const areaBase = root.querySelector('[data-color-picker-area-base]');
    const areaThumb = root.querySelector('[data-color-picker-area-thumb]');
    /** @type {HTMLInputElement | null} */
    const hueInput = root.querySelector('[data-color-picker-hue]');
    const dropperButton = root.querySelector('[data-color-picker-dropper]');
    const preview = root.querySelector('[data-color-picker-preview]');
    const disabled = root.hasAttribute('data-disabled');

    if (
        !(hiddenInput instanceof HTMLInputElement) ||
        !(hexInput instanceof HTMLInputElement) ||
        !(popover instanceof HTMLElement) ||
        !(area instanceof HTMLElement) ||
        !(areaBase instanceof HTMLElement) ||
        !(areaThumb instanceof HTMLElement) ||
        !(hueInput instanceof HTMLInputElement) ||
        !(swatchTrigger instanceof HTMLButtonElement)
    ) {
        return;
    }

    const swatchesContainer = popover.querySelector('[data-color-picker-swatches]');

    const portalMarker = document.createComment('std-color-picker-portal');
    let portalInserted = false;
    const signal = createBindSignal(root);
    let open = false;
    /** @type {(() => void) | null} */
    let releaseScrollLock = null;
    let draggingArea = false;

    let hue = 0;
    let saturation = 100;
    let brightness = 100;

    function getSwatchButtons() {
        return Array.from(popover.querySelectorAll('[data-color-picker-swatch]')).filter(
            (node) => node instanceof HTMLButtonElement && !node.disabled,
        );
    }

    function syncSwatchTabIndex() {
        const buttons = getSwatchButtons();

        buttons.forEach((button, index) => {
            const selected = button.dataset.selected === 'true';
            button.tabIndex = selected || index === 0 ? 0 : -1;
        });
    }

    /**
     * @param {HTMLElement} target
     */
    function dispatchChange(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @param {string} hex
     */
    function syncHsvFromHex(hex) {
        const { r, g, b } = hexToRgb(hex);
        const hsv = rgbToHsv(r, g, b);

        hue = hsv.h;
        saturation = hsv.s;
        brightness = hsv.v;
    }

    function renderPickerUi() {
        areaBase.style.backgroundColor = `hsl(${hue} 100% 50%)`;
        hueInput.value = String(hue);

        const thumbX = (saturation / 100) * area.clientWidth;
        const thumbY = (1 - brightness / 100) * area.clientHeight;

        areaThumb.style.left = `${thumbX}px`;
        areaThumb.style.top = `${thumbY}px`;
    }

    /**
     * @param {string} hex
     * @param {{ syncPicker?: boolean, dispatch?: boolean }} [options]
     */
    function setValue(hex, options = {}) {
        const { syncPicker = true, dispatch = true } = options;

        if (!HEX_PATTERN.test(hex)) {
            return;
        }

        const normalized = hex.toLowerCase();

        hiddenInput.value = normalized;
        hexInput.value = normalized.toUpperCase();

        if (preview instanceof HTMLElement) {
            preview.style.backgroundColor = normalized;
        }

        if (syncPicker) {
            syncHsvFromHex(normalized);
            renderPickerUi();
        }

        root.querySelectorAll('[data-color-picker-swatch]').forEach((button) => {
            if (!(button instanceof HTMLButtonElement)) {
                return;
            }

            const swatchValue = button.getAttribute('data-color-picker-swatch')?.toLowerCase();
            const selected = swatchValue === normalized;

            button.setAttribute('aria-selected', selected ? 'true' : 'false');
            button.dataset.selected = selected ? 'true' : 'false';
        });

        syncSwatchTabIndex();

        if (dispatch) {
            dispatchChange(hiddenInput);
        }
    }

    function ensurePortal() {
        // Keep overlays inside the README media canvas so #readme-media screenshots include them.
        if (root.closest('#readme-media') || popover.closest('#readme-media')) {
            return;
        }

        if (popover.parentElement === document.body) {
            return;
        }

        const parent = popover.parentElement;

        if (parent && !portalInserted) {
            parent.insertBefore(portalMarker, popover);
            portalInserted = true;
        }

        document.body.appendChild(popover);
        popover.dataset.colorPickerPortaled = 'true';
    }

    function positionPopover() {
        ensurePortal();

        const anchor = trigger instanceof HTMLElement ? trigger : hexInput;
        const rect = anchor.getBoundingClientRect();
        const gap = 6;
        const viewportPadding = 8;

        if (root.closest('#readme-media')) {
            if (getComputedStyle(root).position === 'static') {
                root.style.position = 'relative';
            }

            const rootRect = root.getBoundingClientRect();

            popover.style.position = 'absolute';
            popover.style.left = `${Math.max(0, rect.left - rootRect.left)}px`;
            popover.style.top = `${rect.bottom - rootRect.top + gap}px`;
            popover.style.width = `${Math.max(rect.width, 288)}px`;
            popover.style.zIndex = '200';
            popover.style.maxHeight = '';

            return;
        }

        popover.style.position = 'fixed';
        popover.style.left = `${Math.max(viewportPadding, rect.left)}px`;
        popover.style.width = `${Math.max(rect.width, 288)}px`;
        popover.style.zIndex = '200';

        const wasHidden = popover.hidden;
        popover.hidden = false;
        popover.style.visibility = 'hidden';
        popover.style.pointerEvents = 'none';
        const panelHeight = popover.offsetHeight;
        popover.style.visibility = '';
        popover.style.pointerEvents = '';
        popover.hidden = wasHidden;

        let top = rect.bottom + gap;
        const maxBottom = window.innerHeight - viewportPadding;

        if (top + panelHeight > maxBottom) {
            const topAbove = rect.top - gap - panelHeight;

            if (topAbove >= viewportPadding) {
                top = topAbove;
            } else {
                popover.style.maxHeight = `${maxBottom - top}px`;
            }
        } else {
            popover.style.maxHeight = '';
        }

        popover.style.top = `${top}px`;
    }

    function setOpen(next) {
        open = next;

        swatchTrigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        hexInput.setAttribute('aria-expanded', open ? 'true' : 'false');
        popover.hidden = !open;

        if (open) {
            releaseScrollLock?.();
            releaseScrollLock = acquireBodyScrollLock(popover, { signal });
            syncHsvFromHex(hiddenInput.value || '#000000');
            renderPickerUi();
            positionPopover();
            syncSwatchTabIndex();
            focusFirstIn(popover);
        } else {
            releaseScrollLock?.();
            releaseScrollLock = null;
        }
    }

    /**
     * @param {number} clientX
     * @param {number} clientY
     */
    function updateAreaFromPointer(clientX, clientY) {
        const rect = area.getBoundingClientRect();
        const x = Math.max(0, Math.min(rect.width, clientX - rect.left));
        const y = Math.max(0, Math.min(rect.height, clientY - rect.top));

        saturation = (x / rect.width) * 100;
        brightness = 100 - (y / rect.height) * 100;

        setValue(hsvToHex(hue, saturation, brightness), { syncPicker: false });
        renderPickerUi();
    }

    swatchTrigger.addEventListener('click', () => {
        if (disabled) {
            return;
        }

        setOpen(!open);
    });

    hexInput.addEventListener('input', () => {
        if (disabled) {
            return;
        }

        const parsed = parseHexInput(hexInput.value);

        if (parsed) {
            setValue(parsed);
        }
    });

    hexInput.addEventListener('blur', () => {
        if (disabled) {
            return;
        }

        const parsed = parseHexInput(hexInput.value);

        if (parsed) {
            setValue(parsed);
        } else {
            hexInput.value = hiddenInput.value.toUpperCase();
        }
    });

    hueInput.addEventListener('input', () => {
        if (disabled) {
            return;
        }

        hue = Number(hueInput.value);
        setValue(hsvToHex(hue, saturation, brightness), { syncPicker: false });
        renderPickerUi();
    });

    area.addEventListener('pointerdown', (event) => {
        if (disabled) {
            return;
        }

        draggingArea = true;
        area.setPointerCapture(event.pointerId);
        updateAreaFromPointer(event.clientX, event.clientY);
    });

    area.addEventListener('pointermove', (event) => {
        if (!draggingArea || disabled) {
            return;
        }

        updateAreaFromPointer(event.clientX, event.clientY);
    });

    area.addEventListener('pointerup', (event) => {
        draggingArea = false;

        if (area.hasPointerCapture(event.pointerId)) {
            area.releasePointerCapture(event.pointerId);
        }
    });

    area.addEventListener('pointercancel', () => {
        draggingArea = false;
    });

    area.setAttribute('tabindex', '0');
    area.addEventListener('keydown', (event) => {
        if (disabled) {
            return;
        }

        const step = event.shiftKey ? 10 : 2;
        let nextSaturation = saturation;
        let nextBrightness = brightness;

        switch (event.key) {
            case 'ArrowRight':
                nextSaturation = Math.min(100, saturation + step);
                break;
            case 'ArrowLeft':
                nextSaturation = Math.max(0, saturation - step);
                break;
            case 'ArrowUp':
                nextBrightness = Math.min(100, brightness + step);
                break;
            case 'ArrowDown':
                nextBrightness = Math.max(0, brightness - step);
                break;
            default:
                return;
        }

        event.preventDefault();
        saturation = nextSaturation;
        brightness = nextBrightness;
        setValue(hsvToHex(hue, saturation, brightness), { syncPicker: false });
        renderPickerUi();
    });

    root.querySelectorAll('[data-color-picker-swatch]').forEach((button) => {
        button.addEventListener('click', () => {
            if (disabled || !(button instanceof HTMLButtonElement)) {
                return;
            }

            const value = button.getAttribute('data-color-picker-swatch');

            if (value) {
                setValue(value);
            }
        });
    });

    if (swatchesContainer instanceof HTMLElement) {
        swatchesContainer.addEventListener('keydown', (event) => {
            if (disabled) {
                return;
            }

            const buttons = getSwatchButtons();

            if (buttons.length === 0) {
                return;
            }

            const currentIndex = buttons.findIndex((button) => button === document.activeElement);
            const columns = 8;

            /**
             * @param {number} nextIndex
             */
            const focusSwatchAt = (nextIndex) => {
                const button = buttons[nextIndex];

                if (!(button instanceof HTMLButtonElement)) {
                    return;
                }

                buttons.forEach((node, index) => {
                    node.tabIndex = index === nextIndex ? 0 : -1;
                });
                button.focus();
            };

            switch (event.key) {
                case 'ArrowRight':
                    event.preventDefault();
                    focusSwatchAt(Math.min(currentIndex + 1, buttons.length - 1));

                    return;
                case 'ArrowLeft':
                    event.preventDefault();
                    focusSwatchAt(Math.max(currentIndex - 1, 0));

                    return;
                case 'ArrowDown':
                    event.preventDefault();
                    focusSwatchAt(Math.min(currentIndex + columns, buttons.length - 1));

                    return;
                case 'ArrowUp':
                    event.preventDefault();
                    focusSwatchAt(Math.max(currentIndex - columns, 0));

                    return;
                case 'Home':
                    event.preventDefault();
                    focusSwatchAt(0);

                    return;
                case 'End':
                    event.preventDefault();
                    focusSwatchAt(buttons.length - 1);

                    return;
                case 'Enter':
                case ' ':
                    if (currentIndex >= 0) {
                        event.preventDefault();
                        const value = buttons[currentIndex]?.getAttribute(
                            'data-color-picker-swatch',
                        );

                        if (value) {
                            setValue(value);
                        }
                    }

                    return;
                default:
                    return;
            }
        });
    }

    if (dropperButton instanceof HTMLButtonElement && 'EyeDropper' in window) {
        dropperButton.hidden = false;

        dropperButton.addEventListener('click', async () => {
            if (disabled) {
                return;
            }

            try {
                // @ts-expect-error EyeDropper is not in all TS lib versions.
                const eyeDropper = new window.EyeDropper();
                const result = await eyeDropper.open();
                const parsed = parseHexInput(result.sRGBHex);

                if (parsed) {
                    setValue(parsed);
                }
            } catch {
                //
            }
        });
    }

    document.addEventListener(
        'pointerdown',
        (event) => {
            if (!open || disabled) {
                return;
            }

            const target = event.target;

            if (!(target instanceof Node)) {
                return;
            }

            if (root.contains(target) || popover.contains(target)) {
                return;
            }

            setOpen(false);
        },
        { signal },
    );

    document.addEventListener(
        'keydown',
        (event) => {
            if (!open || disabled) {
                return;
            }

            if (event.key === 'Escape') {
                setOpen(false);
                swatchTrigger.focus();

                return;
            }

            if (event.key === 'Tab') {
                trapFocus(event, popover);
            }
        },
        { signal },
    );

    window.addEventListener(
        'resize',
        () => {
            if (open) {
                positionPopover();
            }
        },
        { signal },
    );

    const initial = hiddenInput.value || '#000000';

    if (HEX_PATTERN.test(initial)) {
        setValue(initial, { dispatch: false });
    }
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initColorPickers(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initColorPickers());
    } else {
        initColorPickers();
    }
}
