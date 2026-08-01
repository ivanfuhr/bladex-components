/**
 * Stencil — time picker (vanilla JS).
 */

import { ensurePanelPortaled, positionAnchoredPanel } from './chrono/popover.js';
import { formatTimeLabel } from './chrono/timezone.js';

const SELECTOR = '[data-time-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initTimePickers(root = document) {
    root.querySelectorAll(SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement) || initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindTimePicker(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindTimePicker(root) {
    const hidden = root.querySelector('[data-time-picker-hidden-input]');
    const trigger = root.querySelector('[data-time-picker-trigger]');
    const panel = root.querySelector('[data-time-picker-panel]');
    const valueEl = root.querySelector('[data-time-picker-value]');
    const inputEl = root.querySelector('[data-time-picker-input]');

    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
        return;
    }

    const step = parseInt(root.dataset.timePickerStep ?? '30', 10) || 30;
    const withSeconds = root.hasAttribute('data-time-picker-seconds');
    const locale = root.dataset.timePickerLocale ?? 'en';
    const timeZone = root.dataset.timePickerTimezone ?? 'UTC';
    const unavailable = (root.dataset.timePickerUnavailable ?? '')
        .split(',')
        .map((v) => v.trim())
        .filter(Boolean);

    const portalMarker = document.createComment('stencil-time-picker-portal');
    let open = false;

    const options = buildOptions(step, withSeconds, unavailable);

    panel.innerHTML = '';
    options.forEach((time) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className =
            'flex w-full rounded-lg px-2 py-1.5 text-left text-sm tabular-nums hover:bg-zinc-100 dark:hover:bg-zinc-800';
        button.dataset.timePickerOption = time;
        button.textContent = formatTimeLabel(time, locale, timeZone, withSeconds);
        button.setAttribute('role', 'option');
        panel.appendChild(button);
    });

    function setOpen(next) {
        open = next;
        panel.hidden = !next;

        if (trigger instanceof HTMLElement) {
            trigger.setAttribute('aria-expanded', next ? 'true' : 'false');
        }

        if (next && trigger instanceof HTMLElement) {
            ensurePanelPortaled(panel, root, portalMarker);
            positionAnchoredPanel(panel, trigger);
            panel.focus();
        }
    }

    function apply(time) {
        hidden.value = time;

        if (!time) {
            if (valueEl instanceof HTMLElement) {
                valueEl.textContent = valueEl.getAttribute('data-placeholder-text') ?? '';
                valueEl.setAttribute('data-placeholder', 'true');
            }

            if (inputEl instanceof HTMLInputElement) {
                inputEl.value = '';
            }
        } else {
            const label = formatTimeLabel(time, locale, timeZone, withSeconds);

            if (valueEl instanceof HTMLElement) {
                valueEl.textContent = label;
                valueEl.removeAttribute('data-placeholder');
            }

            if (inputEl instanceof HTMLInputElement) {
                inputEl.value = label;
            }
        }

        panel.querySelectorAll('[data-time-picker-option]').forEach((el) => {
            if (el instanceof HTMLElement) {
                const selected = el.dataset.timePickerOption === time;
                el.setAttribute('aria-selected', selected ? 'true' : 'false');
                el.classList.toggle('bg-zinc-900', selected);
                el.classList.toggle('text-white', selected);
                el.classList.toggle('dark:bg-zinc-100', selected);
                el.classList.toggle('dark:text-zinc-900', selected);
                el.classList.toggle('hover:bg-zinc-100', !selected);
                el.classList.toggle('dark:hover:bg-zinc-800', !selected);
            }
        });

        hidden.dispatchEvent(new Event('input', { bubbles: true }));
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
        setOpen(false);
    }

    trigger?.addEventListener('click', (event) => {
        event.preventDefault();
        setOpen(!open);
    });

    root.querySelectorAll('[data-time-picker-clear]').forEach((clear) => {
        clear.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            apply('');
        });
    });

    panel.addEventListener('click', (event) => {
        const option =
            event.target instanceof Element
                ? event.target.closest('[data-time-picker-option]')
                : null;

        if (option instanceof HTMLElement && option.dataset.timePickerOption) {
            apply(option.dataset.timePickerOption);
        }
    });

    document.addEventListener('pointerdown', (event) => {
        if (!open) {
            return;
        }

        const target = event.target;

        if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
            setOpen(false);
        }
    });

    if (hidden.value) {
        apply(hidden.value);
    }
}

/**
 * @param {number} step minutes
 * @param {boolean} withSeconds
 * @param {string[]} unavailable
 */
function buildOptions(step, withSeconds, unavailable) {
    const options = [];

    for (let minutes = 0; minutes < 24 * 60; minutes += step) {
        const h = Math.floor(minutes / 60);
        const m = minutes % 60;
        const value = withSeconds
            ? `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:00`
            : `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;

        if (!unavailable.includes(value)) {
            options.push(value);
        }
    }

    return options;
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initTimePickers(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initTimePickers());
    } else {
        initTimePickers();
    }
}
