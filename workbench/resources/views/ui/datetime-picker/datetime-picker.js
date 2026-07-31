/**
 * Stencil — datetime picker (vanilla JS).
 */

import { bindCalendar } from './calendar.js';
import { ensurePanelPortaled, positionAnchoredPanel, restorePanelFromPortal } from './chrono/popover.js';
import { toIsoDateTimeString } from './chrono/parse.js';
import { formatTimeLabel } from './chrono/timezone.js';

const SELECTOR = '[data-datetime-picker]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initDatetimePickers(root = document) {
    document.querySelectorAll('[data-datetime-picker-panel][data-stencil-portaled]').forEach((panel) => {
        if (!(panel instanceof HTMLElement) || panel.closest('[data-datetime-picker]')) {
            return;
        }

        panel.remove();
    });

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
    const panel = root.querySelector('[data-datetime-picker-panel]');
    const trigger = root.querySelector('[data-datetime-picker-trigger], [data-date-picker-trigger]');
    const valueEl = root.querySelector('[data-date-picker-value]');
    const calendarEl = root.querySelector('[data-datetime-picker-calendar]');
    const timeList = root.querySelector('[data-datetime-picker-time-list]');

    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
        return;
    }

    const locale = root.dataset.datetimePickerLocale ?? 'en';
    const timeZone = root.dataset.datetimePickerTimezone ?? 'UTC';
    const withSeconds = root.hasAttribute('data-datetime-picker-seconds');
    const step = 30;
    const portalMarker = document.createComment('stencil-datetime-picker-portal');
    let isOpen = false;

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

    function loadFromHidden() {
        if (!hidden.value) {
            selectedDate = '';
            selectedTime = withSeconds ? '00:00:00' : '00:00';
            calendarApi?.setValue('');

            return;
        }

        const [datePart, timePartRaw] = hidden.value.split('T');
        selectedDate = datePart ?? '';
        selectedTime = (timePartRaw ?? '').slice(0, withSeconds ? 8 : 5) || selectedTime;
        calendarApi?.setValue(selectedDate);
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
            positionAnchoredPanel(panel, trigger);
        }

        loadFromHidden();
    }

    function close() {
        isOpen = false;
        panel.hidden = true;
        panel.setAttribute('aria-hidden', 'true');
        panel.removeAttribute('role');
        panel.removeAttribute('aria-modal');
        restorePanelFromPortal(panel, root, portalMarker);

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
        loadFromHidden();
        close();
    });

    document.addEventListener('pointerdown', (event) => {
        if (!isOpen) {
            return;
        }

        const target = event.target;

        if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
            loadFromHidden();
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (!isOpen || event.key !== 'Escape') {
            return;
        }

        loadFromHidden();
        close();
    });

    window.addEventListener(
        'scroll',
        () => {
            if (!isOpen || !(trigger instanceof HTMLElement)) {
                return;
            }

            positionAnchoredPanel(panel, trigger);
        },
        true,
    );

    if (hidden.value) {
        loadFromHidden();
        apply(hidden.value);
    }
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDatetimePickers());
    } else {
        initDatetimePickers();
    }
}
