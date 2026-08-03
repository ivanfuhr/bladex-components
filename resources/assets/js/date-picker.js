/**
 * Stencil — date picker (vanilla JS).
 */

import { bindCalendar } from '../calendar/calendar.js';
import {
    ensurePanelPortaled,
    positionAnchoredPanel,
    restorePanelFromPortal,
} from '../../../js/ui/anchored-panel.js';
import { formatRangeValue } from '../../../js/ui/date-parse.js';
import { formatDateLabel } from '../../../js/ui/date-timezone.js';

const SELECTOR = '[data-date-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initDatePickers(root = document) {
    document
        .querySelectorAll('[data-date-picker-panel][data-stencil-portaled]')
        .forEach((panel) => {
            if (!(panel instanceof HTMLElement) || panel.closest('[data-date-picker]')) {
                return;
            }

            panel.remove();
        });

    root.querySelectorAll(SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindDatePicker(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindDatePicker(root) {
    const hidden = root.querySelector('[data-date-picker-hidden-input]');
    const panel = root.querySelector('[data-date-picker-panel]');
    const trigger =
        root.querySelector('[data-date-picker-trigger]') ??
        root.querySelector('button[data-date-picker-trigger]');
    const valueEl = root.querySelector('[data-date-picker-value]');
    const inputEl = root.querySelector('[data-date-picker-input]');
    const calendarEl = root.querySelector('[data-calendar]');

    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
        return;
    }

    const locale = root.dataset.datePickerLocale ?? 'en';
    const withConfirmation = root.hasAttribute('data-date-picker-with-confirmation');
    const portalMarker = document.createComment('stencil-date-picker-portal');
    const controller = new AbortController();
    const { signal } = controller;
    let isOpen = false;

    const disconnectObserver = new MutationObserver(() => {
        if (!root.isConnected) {
            controller.abort();
            disconnectObserver.disconnect();
        }
    });

    disconnectObserver.observe(document.documentElement, { childList: true, subtree: true });

    /** @type {ReturnType<typeof bindCalendar> | null} */
    let calendarApi = null;

    if (calendarEl instanceof HTMLElement) {
        calendarApi = bindCalendar(calendarEl);
    }

    function displayValue(value) {
        const text = formatDisplay(value, root.dataset.datePickerMode === 'range', locale);

        if (valueEl instanceof HTMLElement) {
            if (text) {
                valueEl.textContent = text;
                valueEl.removeAttribute('data-placeholder');
            } else {
                valueEl.textContent = valueEl.getAttribute('data-placeholder-text') ?? '';
                valueEl.setAttribute('data-placeholder', 'true');
            }
        }

        if (inputEl instanceof HTMLInputElement) {
            inputEl.value = text;
        }
    }

    function syncCalendarFromHidden() {
        calendarApi?.setValue(hidden.value);
    }

    function open() {
        isOpen = true;
        panel.hidden = false;
        panel.removeAttribute('aria-hidden');
        panel.setAttribute('role', 'dialog');
        panel.setAttribute('aria-modal', 'true');

        if (trigger instanceof HTMLElement) {
            trigger.setAttribute('aria-expanded', 'true');
            ensurePanelPortaled(panel, root, portalMarker);
            positionAnchoredPanel(panel, trigger, { fitContent: true });
        }

        syncCalendarFromHidden();

        if (calendarEl instanceof HTMLElement) {
            calendarEl.focus();
        } else {
            panel.focus();
        }
    }

    function close() {
        isOpen = false;
        panel.hidden = true;
        panel.setAttribute('aria-hidden', 'true');
        panel.removeAttribute('role');
        panel.removeAttribute('aria-modal');
        restorePanelFromPortal(panel, root, portalMarker);

        if (trigger instanceof HTMLElement) {
            trigger.setAttribute('aria-expanded', 'false');
            trigger.focus();
        }
    }

    function revertSelection() {
        syncCalendarFromHidden();
    }

    function applyValue(value) {
        hidden.value = value;
        displayValue(value);
        calendarApi?.setValue(value);
        hidden.dispatchEvent(new Event('input', { bubbles: true }));
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
    }

    root.querySelector('[data-date-picker-confirm]')?.addEventListener('click', () => {
        const value = calendarApi?.getValue() ?? hidden.value;
        applyValue(value);
        close();
    });

    root.querySelector('[data-date-picker-cancel]')?.addEventListener('click', () => {
        revertSelection();
        close();
    });

    root.querySelectorAll('[data-date-picker-preset]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!(button instanceof HTMLElement)) {
                return;
            }

            const start = button.dataset.datePickerPresetStart ?? '';
            const end = button.dataset.datePickerPresetEnd ?? '';
            const value = formatRangeValue(start, end);

            if (!withConfirmation) {
                applyValue(value);
                close();

                return;
            }

            calendarApi?.setValue(value);
        });
    });

    root.querySelectorAll('[data-date-picker-clear]').forEach((clear) => {
        clear.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            applyValue('');
            close();
        });
    });

    const openOnClick = (event) => {
        event.preventDefault();
        open();
    };

    if (trigger instanceof HTMLElement) {
        trigger.addEventListener('click', openOnClick);
    }

    calendarEl?.addEventListener('calendar:change', (event) => {
        if (!(event instanceof CustomEvent)) {
            return;
        }

        const value = event.detail?.value ?? '';

        if (!withConfirmation && value) {
            applyValue(value);
            close();
        }
    });

    document.addEventListener(
        'pointerdown',
        (event) => {
            if (!isOpen) {
                return;
            }

            const target = event.target;

            if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
                revertSelection();
                close();
            }
        },
        { signal },
    );

    document.addEventListener(
        'keydown',
        (event) => {
            if (!isOpen || event.key !== 'Escape') {
                return;
            }

            revertSelection();
            close();
        },
        { signal },
    );

    window.addEventListener(
        'scroll',
        () => {
            if (!isOpen || !(trigger instanceof HTMLElement)) {
                return;
            }

            positionAnchoredPanel(panel, trigger, { fitContent: true });
        },
        { capture: true, signal },
    );

    displayValue(hidden.value);
}

/**
 * @param {string} value
 * @param {boolean} range
 * @param {string} locale
 */
function formatDisplay(value, range, locale) {
    if (!value) {
        return '';
    }

    if (range && value.includes('/')) {
        const [start, end] = value.split('/');

        return `${formatDateLabel(start, locale)} – ${formatDateLabel(end, locale)}`;
    }

    if (value.includes(',')) {
        return value
            .split(',')
            .map((part) => formatDateLabel(part.trim(), locale))
            .join(', ');
    }

    return formatDateLabel(value, locale);
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initDatePickers(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDatePickers());
    } else {
        initDatePickers();
    }
}
