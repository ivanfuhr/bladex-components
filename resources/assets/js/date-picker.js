/**
 * Stencil — date picker (vanilla JS).
 */

import { bindCalendar } from './calendar.js';
import { formatRangeValue } from './chrono/parse.js';
import { formatDateValue } from './chrono/timezone.js';

const SELECTOR = '[data-date-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initDatePickers(root = document) {
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
    const dialog = root.querySelector('[data-date-picker-dialog]');
    const trigger =
        root.querySelector('[data-date-picker-trigger]') ??
        root.querySelector('button[data-date-picker-trigger]');
    const valueEl = root.querySelector('[data-date-picker-value]');
    const inputEl = root.querySelector('[data-date-picker-input]');
    const calendarEl = root.querySelector('[data-calendar]');

    if (!(hidden instanceof HTMLInputElement) || !(dialog instanceof HTMLDialogElement)) {
        return;
    }

    const locale = root.dataset.datePickerLocale ?? 'en';
    const withConfirmation = root.hasAttribute('data-date-picker-with-confirmation');

    /** @type {ReturnType<typeof bindCalendar> | null} */
    let calendarApi = null;

    if (calendarEl instanceof HTMLElement) {
        calendarApi = bindCalendar(calendarEl);
    }

    function displayValue(value) {
        const text = formatDisplay(value, root.dataset.datePickerMode === 'range', locale);

        if (valueEl instanceof HTMLElement) {
            valueEl.textContent = text || valueEl.getAttribute('data-placeholder') || '';
            if (text) {
                valueEl.removeAttribute('data-placeholder');
            }
        }

        if (inputEl instanceof HTMLInputElement) {
            inputEl.value = text;
        }
    }

    function open() {
        if (typeof dialog.showModal === 'function') {
            dialog.showModal();
        } else {
            dialog.setAttribute('open', '');
        }

        const focusTarget = trigger instanceof HTMLElement ? trigger : dialog;
        focusTarget.setAttribute('aria-expanded', 'true');
    }

    function close() {
        if (dialog.open) {
            dialog.close();
        }

        if (trigger instanceof HTMLElement) {
            trigger.setAttribute('aria-expanded', 'false');
        }
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
        calendarEl?.dispatchEvent(new Event('calendar:cancel'));
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

    dialog.addEventListener('cancel', (event) => {
        event.preventDefault();
        close();
    });

    calendarEl?.addEventListener('calendar:change', (event) => {
        if (!(event instanceof CustomEvent)) {
            return;
        }

        const value = event.detail?.value ?? '';

        if (!withConfirmation) {
            applyValue(value);
            close();
        }
    });

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

        return `${start} – ${end}`;
    }

    return value;
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDatePickers());
    } else {
        initDatePickers();
    }
}
