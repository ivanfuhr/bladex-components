/**
 * Stencil — time picker (vanilla JS).
 */

import {
    ensurePanelPortaled,
    positionAnchoredPanel,
    restorePanelFromPortal,
} from './shared/anchored-panel.js';
import { formatTimeLabel } from './shared/date-timezone.js';
import { createBindSignal } from './shared/lifecycle.js';
import { acquireBodyScrollLock } from './shared/scroll-lock.js';

const SELECTOR = '[data-time-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initTimePickers(root = document) {
    document
        .querySelectorAll('[data-time-picker-panel][data-stencil-portaled]')
        .forEach((panel) => {
            if (!(panel instanceof HTMLElement) || panel.closest('[data-time-picker]')) {
                return;
            }

            panel.remove();
        });

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
    const signal = createBindSignal(root);
    let open = false;
    /** @type {(() => void) | null} */
    let releaseScrollLock = null;
    /** @type {number} */
    let activeIndex = 0;

    const options = buildOptions(step, withSeconds, unavailable);

    panel.setAttribute('role', 'listbox');
    panel.tabIndex = -1;
    panel.innerHTML = '';
    options.forEach((time) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className =
            'flex w-full rounded-lg px-2 py-1.5 text-left text-sm tabular-nums hover:bg-zinc-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20';
        button.dataset.timePickerOption = time;
        const label = formatTimeLabel(time, locale, timeZone, withSeconds);
        button.textContent = label;
        button.setAttribute('aria-label', label);
        button.setAttribute('role', 'option');
        button.tabIndex = -1;
        panel.appendChild(button);
    });

    function optionElements() {
        return [...panel.querySelectorAll('[data-time-picker-option]')].filter(
            (el) => el instanceof HTMLElement,
        );
    }

    function focusOption(index) {
        const list = optionElements();

        if (list.length === 0) {
            return;
        }

        activeIndex = Math.max(0, Math.min(index, list.length - 1));

        list.forEach((el, i) => {
            el.tabIndex = i === activeIndex ? 0 : -1;
        });

        const active = list[activeIndex];
        active?.focus();
        active?.scrollIntoView({ block: 'nearest' });
    }

    function setOpen(next) {
        const wasOpen = open;
        open = next;
        panel.hidden = !next;

        if (trigger instanceof HTMLElement) {
            trigger.setAttribute('aria-expanded', next ? 'true' : 'false');
        }

        if (next && trigger instanceof HTMLElement) {
            releaseScrollLock?.();
            releaseScrollLock = acquireBodyScrollLock(panel, { signal });
            ensurePanelPortaled(panel, root, portalMarker);
            positionAnchoredPanel(panel, trigger);

            const list = optionElements();
            const selectedIdx = list.findIndex((el) => el.getAttribute('aria-selected') === 'true');
            focusOption(selectedIdx >= 0 ? selectedIdx : 0);
        } else if (wasOpen && !next) {
            releaseScrollLock?.();
            releaseScrollLock = null;
            restorePanelFromPortal(panel, root, portalMarker);

            if (trigger instanceof HTMLElement) {
                trigger.focus();
            }
        } else if (!next) {
            releaseScrollLock?.();
            releaseScrollLock = null;
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

    function isTriggerDisabled() {
        return (
            (trigger instanceof HTMLButtonElement && trigger.disabled) ||
            (trigger instanceof HTMLInputElement && trigger.disabled) ||
            (trigger instanceof HTMLElement && trigger.getAttribute('aria-disabled') === 'true')
        );
    }

    trigger?.addEventListener('click', (event) => {
        event.preventDefault();

        if (isTriggerDisabled()) {
            return;
        }

        setOpen(!open);
    });

    trigger?.addEventListener('keydown', (event) => {
        if (isTriggerDisabled() || open) {
            return;
        }

        if (
            event.key === 'ArrowDown' ||
            event.key === 'ArrowUp' ||
            event.key === 'Enter' ||
            event.key === ' '
        ) {
            event.preventDefault();
            setOpen(true);
        }
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

    panel.addEventListener('keydown', (event) => {
        if (!open) {
            return;
        }

        const list = optionElements();

        if (list.length === 0) {
            return;
        }

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                focusOption(activeIndex + 1);
                break;
            case 'ArrowUp':
                event.preventDefault();
                focusOption(activeIndex - 1);
                break;
            case 'Home':
                event.preventDefault();
                focusOption(0);
                break;
            case 'End':
                event.preventDefault();
                focusOption(list.length - 1);
                break;
            case 'Enter':
            case ' ':
                event.preventDefault();
                {
                    const active = list[activeIndex];
                    if (active?.dataset.timePickerOption) {
                        apply(active.dataset.timePickerOption);
                    }
                }
                break;
            case 'Escape':
                event.preventDefault();
                setOpen(false);
                break;
            case 'Tab':
                setOpen(false);
                break;
            default:
                break;
        }
    });

    document.addEventListener(
        'pointerdown',
        (event) => {
            if (!open) {
                return;
            }

            const target = event.target;

            if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
                setOpen(false);
            }
        },
        { signal },
    );

    document.addEventListener(
        'keydown',
        (event) => {
            if (!open || event.key !== 'Escape') {
                return;
            }

            event.preventDefault();
            setOpen(false);
        },
        { signal },
    );

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
