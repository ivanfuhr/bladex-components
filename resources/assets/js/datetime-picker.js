/**
 * Stencil — datetime picker (vanilla JS).
 */

import { bindCalendar } from './calendar.js';
import { toIsoDateTimeString } from './chrono/parse.js';
import { formatTimeLabel } from './chrono/timezone.js';

const SELECTOR = '[data-datetime-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initDatetimePickers(root = document) {
    root.querySelectorAll(SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement) || initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindDatetimePicker(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindDatetimePicker(root) {
    const hidden = root.querySelector('[data-datetime-picker-hidden-input]');
    const dialog = root.querySelector('[data-datetime-picker-dialog]');
    const trigger = root.querySelector('[data-datetime-picker-trigger], [data-date-picker-trigger]');
    const valueEl = root.querySelector('[data-date-picker-value]');
    const calendarEl = root.querySelector('[data-datetime-picker-calendar]');
    const timeList = root.querySelector('[data-datetime-picker-time-list]');

    if (!(hidden instanceof HTMLInputElement) || !(dialog instanceof HTMLDialogElement)) {
        return;
    }

    const locale = root.dataset.datetimePickerLocale ?? 'en';
    const timeZone = root.dataset.datetimePickerTimezone ?? 'UTC';
    const withSeconds = root.hasAttribute('data-datetime-picker-seconds');
    const step = 30;

    let selectedDate = '';
    let selectedTime = withSeconds ? '00:00:00' : '00:00';

    /** @type {ReturnType<typeof bindCalendar> | null} */
    let calendarApi = null;

    if (calendarEl instanceof HTMLElement) {
        calendarApi = bindCalendar(calendarEl);
    }

    if (timeList instanceof HTMLElement) {
        for (let minutes = 0; minutes < 24 * 60; minutes += step) {
            const h = Math.floor(minutes / 60);
            const m = minutes % 60;
            const value = withSeconds
                ? `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:00`
                : `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;

            const button = document.createElement('button');
            button.type = 'button';
            button.className =
                'flex w-full rounded-lg px-2 py-1.5 text-left text-sm tabular-nums hover:bg-zinc-100 dark:hover:bg-zinc-800';
            button.dataset.datetimePickerTime = value;
            button.textContent = formatTimeLabel(value, locale, timeZone, withSeconds);
            timeList.appendChild(button);
        }
    }

    function open() {
        dialog.showModal?.();
        trigger?.setAttribute('aria-expanded', 'true');
    }

    function close() {
        if (dialog.open) {
            dialog.close();
        }

        trigger?.setAttribute('aria-expanded', 'false');
    }

    function composeIso() {
        if (!selectedDate) {
            return '';
        }

        const [h, m, s] = selectedTime.split(':');
        const date = new Date(
            Date.UTC(
                Number(selectedDate.slice(0, 4)),
                Number(selectedDate.slice(5, 7)) - 1,
                Number(selectedDate.slice(8, 10)),
                Number(h),
                Number(m),
                Number(s ?? 0),
            ),
        );

        return toIsoDateTimeString(date);
    }

    function apply(value) {
        hidden.value = value;

        if (valueEl instanceof HTMLElement) {
            valueEl.textContent = value || valueEl.textContent;
        }

        hidden.dispatchEvent(new Event('input', { bubbles: true }));
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
    }

    trigger?.addEventListener('click', (event) => {
        event.preventDefault();
        open();
    });

    calendarEl?.addEventListener('calendar:change', (event) => {
        if (event instanceof CustomEvent) {
            selectedDate = event.detail?.value ?? '';
        }
    });

    timeList?.addEventListener('click', (event) => {
        const option =
            event.target instanceof Element
                ? event.target.closest('[data-datetime-picker-time]')
                : null;

        if (option instanceof HTMLElement && option.dataset.datetimePickerTime) {
            selectedTime = option.dataset.datetimePickerTime;
        }
    });

    root.querySelector('[data-datetime-picker-confirm]')?.addEventListener('click', () => {
        apply(composeIso());
        close();
    });

    root.querySelector('[data-datetime-picker-cancel]')?.addEventListener('click', () => {
        close();
    });

    if (hidden.value) {
        const [datePart, timePartRaw] = hidden.value.split('T');
        selectedDate = datePart ?? '';
        selectedTime = (timePartRaw ?? '').slice(0, withSeconds ? 8 : 5) || selectedTime;
        calendarApi?.setValue(selectedDate);
    }
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDatetimePickers());
    } else {
        initDatetimePickers();
    }
}
