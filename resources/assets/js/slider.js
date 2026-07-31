/**
 * Stencil — accessible slider / range control (vanilla JS, no Alpine).
 */

const SLIDER_SELECTOR = '[data-slider]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initSliders(root = document) {
    root.querySelectorAll(SLIDER_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindSlider(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindSlider(root) {
    /**
     * @returns {HTMLInputElement[]}
     */
    function hiddenInputs() {
        return Array.from(root.querySelectorAll('[data-slider-hidden-input]'))
            .filter((node) => node instanceof HTMLInputElement)
            .sort((a, b) => {
                const ai = Number.parseInt(a.dataset.index ?? '', 10);
                const bi = Number.parseInt(b.dataset.index ?? '', 10);

                return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
            });
    }

    /**
     * @returns {HTMLElement[]}
     */
    function thumbs() {
        return Array.from(root.querySelectorAll('[data-slider-thumb]'))
            .filter((node) => node instanceof HTMLElement)
            .sort((a, b) => {
                const ai = Number.parseInt(a.dataset.index ?? '', 10);
                const bi = Number.parseInt(b.dataset.index ?? '', 10);

                return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
            });
    }

    const track = root.querySelector('[data-slider-track]');
    const rangeEl = root.querySelector('[data-slider-range]');

    if (!(track instanceof HTMLElement)) {
        return;
    }

    const min = parseNumber(root.getAttribute('data-slider-min'), 0);
    const max = parseNumber(root.getAttribute('data-slider-max'), 100);
    const step = Math.max(parseNumber(root.getAttribute('data-slider-step'), 1), Number.EPSILON);
    const isRange = root.getAttribute('data-slider-range') === 'true';

    /**
     * @returns {boolean}
     */
    function isDisabled() {
        return root.hasAttribute('data-disabled');
    }

    /**
     * @returns {number[]}
     */
    function readValues() {
        const inputs = hiddenInputs();
        const thumbEls = thumbs();
        const count = isRange ? 2 : 1;

        /** @type {number[]} */
        const values = [];

        for (let index = 0; index < count; index += 1) {
            const fromInput = inputs[index]?.value;
            const fromThumb = thumbEls[index]?.getAttribute('aria-valuenow');
            const raw = fromInput ?? fromThumb ?? String(index === 0 ? min : max);
            values.push(snap(parseNumber(raw, index === 0 ? min : max)));
        }

        if (isRange && values.length === 2 && values[0] > values[1]) {
            return [values[1], values[0]];
        }

        return values;
    }

    /**
     * @param {number} value
     */
    function snap(value) {
        const clamped = Math.min(max, Math.max(min, value));
        const steps = Math.round((clamped - min) / step);

        return clamp(min + (steps * step));
    }

    /**
     * @param {number} value
     */
    function clamp(value) {
        return Math.min(max, Math.max(min, value));
    }

    /**
     * @param {number} value
     */
    function format(value) {
        if (Number.isInteger(step) && Number.isInteger(value)) {
            return String(value);
        }

        const precision = stepPrecision(step);
        const fixed = value.toFixed(precision);

        return fixed.replace(/\.?0+$/, '');
    }

    /**
     * @param {number} clientX
     */
    function valueFromPointer(clientX) {
        const rect = track.getBoundingClientRect();

        if (rect.width <= 0) {
            return min;
        }

        const ratio = Math.min(1, Math.max(0, (clientX - rect.left) / rect.width));

        return snap(min + (ratio * (max - min)));
    }

    /**
     * @param {number[]} values
     * @param {{ dispatch?: boolean }} [options]
     */
    function applyValues(values, options = {}) {
        const next = isRange
            ? [
                snap(values[0] ?? min),
                snap(values[1] ?? max),
            ]
            : [snap(values[0] ?? min)];

        if (isRange && next[0] > next[1]) {
            // Keep thumbs ordered while dragging either end.
            if (activeIndex === 0) {
                next[0] = next[1];
            } else {
                next[1] = next[0];
            }
        }

        const inputs = hiddenInputs();
        const thumbEls = thumbs();
        const span = max - min;

        next.forEach((value, index) => {
            const formatted = format(value);
            const percent = span > 0 ? ((value - min) / span) * 100 : 0;
            const input = inputs[index];
            const thumb = thumbEls[index];

            if (input instanceof HTMLInputElement && input.value !== formatted) {
                input.value = formatted;

                if (options.dispatch !== false) {
                    dispatchValueEvents(input);
                }
            } else if (input instanceof HTMLInputElement) {
                input.value = formatted;
            }

            if (thumb instanceof HTMLElement) {
                thumb.style.left = `${percent}%`;
                thumb.setAttribute('aria-valuenow', formatted);
                thumb.setAttribute('aria-valuetext', formatted);
                thumb.setAttribute('aria-valuemin', format(min));
                thumb.setAttribute('aria-valuemax', format(max));
            }
        });

        if (rangeEl instanceof HTMLElement) {
            if (isRange) {
                const start = span > 0 ? ((next[0] - min) / span) * 100 : 0;
                const end = span > 0 ? ((next[1] - min) / span) * 100 : 100;
                rangeEl.style.left = `${start}%`;
                rangeEl.style.width = `${Math.max(0, end - start)}%`;
            } else {
                const end = span > 0 ? ((next[0] - min) / span) * 100 : 0;
                rangeEl.style.left = '0%';
                rangeEl.style.width = `${Math.max(0, end)}%`;
            }
        }
    }

    /**
     * @param {HTMLElement} target
     */
    function dispatchValueEvents(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /** @type {number | null} */
    let activeIndex = null;
    /** @type {number | null} */
    let pointerId = null;

    /**
     * @param {number} clientX
     * @param {number | null} preferredIndex
     */
    function setFromPointer(clientX, preferredIndex = null) {
        const nextValue = valueFromPointer(clientX);
        const current = readValues();

        if (! isRange) {
            applyValues([nextValue]);

            return;
        }

        let index = preferredIndex;

        if (index === null) {
            const distanceToLow = Math.abs(nextValue - current[0]);
            const distanceToHigh = Math.abs(nextValue - current[1]);
            index = distanceToLow <= distanceToHigh ? 0 : 1;
        }

        activeIndex = index;
        const next = [...current];
        next[index] = nextValue;
        applyValues(next);
    }

    /**
     * @param {number} index
     * @param {number} deltaSteps
     */
    function nudge(index, deltaSteps) {
        const current = readValues();
        const next = [...current];
        next[index] = snap((current[index] ?? min) + (deltaSteps * step));
        activeIndex = index;
        applyValues(next);
    }

    /**
     * @param {PointerEvent} event
     */
    function onPointerDown(event) {
        if (isDisabled() || event.button !== 0) {
            return;
        }

        const target = event.target instanceof Element ? event.target : null;
        const thumb = target?.closest('[data-slider-thumb]');
        const preferredIndex = thumb instanceof HTMLElement
            ? Number.parseInt(thumb.dataset.index ?? '0', 10)
            : null;

        root.setPointerCapture?.(event.pointerId);
        pointerId = event.pointerId;
        setFromPointer(event.clientX, Number.isFinite(preferredIndex) ? preferredIndex : null);

        const thumbEls = thumbs();
        const focusIndex = activeIndex ?? 0;
        thumbEls[focusIndex]?.focus();

        event.preventDefault();
    }

    /**
     * @param {PointerEvent} event
     */
    function onPointerMove(event) {
        if (pointerId === null || event.pointerId !== pointerId || isDisabled()) {
            return;
        }

        setFromPointer(event.clientX, activeIndex);
        event.preventDefault();
    }

    /**
     * @param {PointerEvent} event
     */
    function onPointerUp(event) {
        if (pointerId === null || event.pointerId !== pointerId) {
            return;
        }

        pointerId = null;
        activeIndex = null;

        if (root.hasPointerCapture?.(event.pointerId)) {
            root.releasePointerCapture(event.pointerId);
        }
    }

    root.addEventListener('pointerdown', onPointerDown);
    root.addEventListener('pointermove', onPointerMove);
    root.addEventListener('pointerup', onPointerUp);
    root.addEventListener('pointercancel', onPointerUp);

    thumbs().forEach((thumb, index) => {
        thumb.addEventListener('keydown', (event) => {
            if (isDisabled() || thumb.getAttribute('aria-disabled') === 'true') {
                return;
            }

            const largeStep = Math.max(step, (max - min) / 10);

            switch (event.key) {
                case 'ArrowLeft':
                case 'ArrowDown':
                    event.preventDefault();
                    nudge(index, -1);
                    break;
                case 'ArrowRight':
                case 'ArrowUp':
                    event.preventDefault();
                    nudge(index, 1);
                    break;
                case 'PageDown':
                    event.preventDefault();
                    nudge(index, -Math.max(1, Math.round(largeStep / step)));
                    break;
                case 'PageUp':
                    event.preventDefault();
                    nudge(index, Math.max(1, Math.round(largeStep / step)));
                    break;
                case 'Home':
                    event.preventDefault();
                    activeIndex = index;
                    {
                        const current = readValues();
                        const next = [...current];
                        next[index] = min;
                        applyValues(next);
                    }
                    break;
                case 'End':
                    event.preventDefault();
                    activeIndex = index;
                    {
                        const current = readValues();
                        const next = [...current];
                        next[index] = max;
                        applyValues(next);
                    }
                    break;
                default:
                    break;
            }
        });
    });

    applyValues(readValues(), { dispatch: false });
}

/**
 * @param {string | null} value
 * @param {number} fallback
 */
function parseNumber(value, fallback) {
    const parsed = Number.parseFloat(value ?? '');

    return Number.isFinite(parsed) ? parsed : fallback;
}

/**
 * @param {number} step
 */
function stepPrecision(step) {
    const text = String(step);

    if (! text.includes('.')) {
        return 0;
    }

    return text.split('.')[1]?.length ?? 0;
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initSliders());
    } else {
        initSliders();
    }
}
