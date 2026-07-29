/**
 * Stencil — calendar grid (vanilla JS).
 */

import { DateValue } from './chrono/date-value.js';
import { formatRangeValue, parseRangeValue } from './chrono/parse.js';
import { formatDateValue, todayInTimeZone } from './chrono/timezone.js';

const CALENDAR_SELECTOR = '[data-calendar]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initCalendars(root = document) {
    root.querySelectorAll(CALENDAR_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindCalendar(element);
    });
}

/**
 * @param {HTMLElement} root
 */
export function bindCalendar(root) {
    if (root.dataset.calendarBound === 'true') {
        return {
            getValue: () => root.dataset.calendarValue ?? '',
            setValue: () => {},
            confirm: () => {},
        };
    }

    root.dataset.calendarBound = 'true';

    const config = readConfig(root);
    const state = createState(root, config);

    const monthsEl = root.querySelector('[data-calendar-months]');
    const prevBtn = root.querySelector('[data-calendar-prev]');
    const nextBtn = root.querySelector('[data-calendar-next]');
    const todayBtn = root.querySelector('[data-calendar-today]');
    const monthLabel = root.querySelector('[data-calendar-month-label]');

    function render() {
        if (!(monthsEl instanceof HTMLElement)) {
            return;
        }

        monthsEl.innerHTML = '';

        for (let i = 0; i < config.monthCount; i++) {
            const view = state.viewMonth.addMonths(i);
            monthsEl.appendChild(buildMonthTable(view, config, state));
        }

        if (monthLabel instanceof HTMLElement) {
            const first = state.viewMonth;
            monthLabel.textContent = formatDateValue(first, config.locale, {
                month: 'long',
                year: 'numeric',
            });
        }

        if (todayBtn instanceof HTMLElement) {
            const label = todayBtn.querySelector('[data-calendar-today-label]');
            if (label instanceof HTMLElement) {
                label.textContent = String(state.today.getDay());
            }
        }

        root.dispatchEvent(new CustomEvent('calendar:render', { bubbles: true }));
    }

    function commitSelection() {
        const value = serializeSelection(state, config.mode);
        root.dataset.calendarValue = value;
        root.dispatchEvent(
            new CustomEvent('calendar:change', {
                bubbles: true,
                detail: { value, state: { ...state.selection } },
            }),
        );
    }

    prevBtn?.addEventListener('click', () => {
        state.viewMonth = state.viewMonth.addMonths(-1);
        render();
    });

    nextBtn?.addEventListener('click', () => {
        state.viewMonth = state.viewMonth.addMonths(1);
        render();
    });

    todayBtn?.addEventListener('click', () => {
        if (state.today.isSameDay(state.viewMonth) === false) {
            state.viewMonth = state.today.getCopy();
            render();

            return;
        }

        selectDay(state.today, state, config);
        render();
        commitSelection();
    });

    root.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target.closest('[data-calendar-day]') : null;

        if (!(target instanceof HTMLButtonElement) || target.disabled) {
            return;
        }

        const iso = target.dataset.calendarDay;

        if (!iso) {
            return;
        }

        const day = DateValue.fromIsoDateString(iso);

        if (!day) {
            return;
        }

        selectDay(day, state, config);
        render();

        if (!config.withConfirmation) {
            commitSelection();
        }
    });

    root.addEventListener('keydown', (event) => {
        if (!['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(event.key)) {
            return;
        }

        event.preventDefault();
        const delta = event.key === 'ArrowLeft' ? -1 : event.key === 'ArrowRight' ? 1 : event.key === 'ArrowUp' ? -7 : 7;
        const base =
            state.selection.focus ?? state.selection.start ?? state.selection.end ?? state.today;
        const next = base.incrementDays(delta);

        state.selection.focus = next;
        selectDay(next, state, config);
        render();

        if (!config.withConfirmation) {
            commitSelection();
        }
    });

    root.addEventListener('calendar:confirm', () => {
        commitSelection();
    });

    root.addEventListener('calendar:cancel', () => {
        loadInitialSelection(state, config, initial);
        render();
    });

    render();

    return {
        getValue: () => serializeSelection(state, config.mode),
        setValue: (value) => {
            loadValueIntoState(value, state, config.mode);
            render();
        },
        confirm: commitSelection,
    };
}

/**
 * @param {HTMLElement} root
 */
function readConfig(root) {
    const mode = root.dataset.calendarMode === 'range' ? 'range' : 'single';

    return {
        mode,
        monthCount: Math.max(1, parseInt(root.dataset.calendarMonths ?? '1', 10) || 1),
        locale: root.dataset.calendarLocale ?? 'en',
        timezone: root.dataset.calendarTimezone ?? 'UTC',
        startDay: parseInt(root.dataset.calendarStartDay ?? '0', 10) || 0,
        min: parseBound(root.dataset.calendarMin),
        max: parseBound(root.dataset.calendarMax),
        unavailable: (root.dataset.calendarUnavailable ?? '')
            .split(',')
            .map((s) => s.trim())
            .filter(Boolean),
        minRange: parseInt(root.dataset.calendarMinRange ?? '', 10) || null,
        maxRange: parseInt(root.dataset.calendarMaxRange ?? '', 10) || null,
        withConfirmation: root.closest('[data-date-picker-with-confirmation]') !== null,
        sizeClass: root.dataset.calendarSizeClass ?? 'size-10 text-sm',
        weekNumbers: root.hasAttribute('data-calendar-week-numbers'),
        fixedWeeks: root.hasAttribute('data-calendar-fixed-weeks'),
    };
}

/**
 * @param {string | undefined} bound
 */
function parseBound(bound) {
    if (!bound) {
        return null;
    }

    if (bound === 'today') {
        return 'today';
    }

    return DateValue.fromIsoDateString(bound);
}

/**
 * @param {HTMLElement} root
 * @param {ReturnType<typeof readConfig>} config
 */
function createState(root, config) {
    const today = todayInTimeZone(config.timezone);
    const openTo = DateValue.fromIsoDateString(root.dataset.calendarOpenTo ?? '');
    const initial = root.dataset.calendarValue ?? '';

    const state = {
        today,
        viewMonth: openTo ?? today,
        selection: {
            start: null,
            end: null,
            focus: null,
        },
    };

    loadInitialSelection(state, config, initial);

    return state;
}

/**
 * @param {{ selection: { start: DateValue | null, end: DateValue | null, focus: DateValue | null }, today: DateValue, viewMonth: DateValue }} state
 * @param {ReturnType<typeof readConfig>} config
 * @param {string} [initial]
 */
function loadInitialSelection(state, config, initial = '') {
    loadValueIntoState(initial || '', state, config.mode);

    if (state.selection.start) {
        state.viewMonth = state.selection.start.getCopy();
    }
}

/**
 * @param {string} value
 * @param {{ selection: { start: DateValue | null, end: DateValue | null } }} state
 * @param {string} mode
 */
function loadValueIntoState(value, state, mode) {
    state.selection.start = null;
    state.selection.end = null;

    if (!value) {
        return;
    }

    if (mode === 'range') {
        const { start, end } = parseRangeValue(value);
        state.selection.start = DateValue.fromIsoDateString(start ?? '');
        state.selection.end = DateValue.fromIsoDateString(end ?? '');

        return;
    }

    state.selection.start = DateValue.fromIsoDateString(value.split(',')[0] ?? value);
}

/**
 * @param {DateValue} day
 * @param {{ selection: { start: DateValue | null, end: DateValue | null, focus: DateValue | null } }} state
 * @param {ReturnType<typeof readConfig>} config
 */
function selectDay(day, state, config) {
    if (config.mode === 'range') {
        if (!state.selection.start || (state.selection.start && state.selection.end)) {
            state.selection.start = day;
            state.selection.end = null;
        } else if (day.isBefore(state.selection.start)) {
            state.selection.end = state.selection.start;
            state.selection.start = day;
        } else {
            state.selection.end = day;
        }

        if (state.selection.start && state.selection.end && config.minRange) {
            const days = diffDays(state.selection.start, state.selection.end) + 1;
            if (days < config.minRange) {
                state.selection.end = null;
            }
        }

        return;
    }

    state.selection.start = day;
    state.selection.end = null;
}

/**
 * @param {DateValue} a
 * @param {DateValue} b
 */
function diffDays(a, b) {
    const ms = Math.abs(b.getDate().getTime() - a.getDate().getTime());

    return Math.floor(ms / (24 * 60 * 60 * 1000));
}

/**
 * @param {{ selection: { start: DateValue | null, end: DateValue | null } }} state
 * @param {string} mode
 */
function serializeSelection(state, mode) {
    if (mode === 'range') {
        return formatRangeValue(
            state.selection.start?.toIsoDateString() ?? null,
            state.selection.end?.toIsoDateString() ?? null,
        );
    }

    return state.selection.start?.toIsoDateString() ?? '';
}

/**
 * @param {DateValue} viewMonth
 * @param {ReturnType<typeof readConfig>} config
 * @param {{ today: DateValue, selection: { start: DateValue | null, end: DateValue | null } }} state
 */
function buildMonthTable(viewMonth, config, state) {
    const wrap = document.createElement('div');
    wrap.className = 'calendar__month';

    const table = document.createElement('table');
    table.setAttribute('role', 'grid');
    table.className = 'border-collapse';

    const thead = document.createElement('thead');
    const headRow = document.createElement('tr');
    headRow.className = 'flex';

    for (let i = 0; i < 7; i++) {
        const th = document.createElement('th');
        th.scope = 'col';
        th.className = `flex ${config.sizeClass} items-center font-medium text-zinc-500`;
        const idx = (i + config.startDay) % 7;
        const date = new Date(2024, 0, 7 + idx);
        th.textContent = new Intl.DateTimeFormat(config.locale, { weekday: 'narrow' }).format(date);
        headRow.appendChild(th);
    }

    thead.appendChild(headRow);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    const first = new DateValue(viewMonth.getYear(), viewMonth.getMonth(), 1);
    let cursor = first.incrementDays(-((first.getDayOfWeek() - config.startDay + 7) % 7));

    const weeks = config.fixedWeeks ? 6 : 5;

    for (let w = 0; w < weeks; w++) {
        const row = document.createElement('tr');
        row.className = 'mt-1 flex';

        for (let d = 0; d < 7; d++) {
            const cellDay = cursor;
            cursor = cursor.incrementDays(1);

            const td = document.createElement('td');
            td.className = 'p-0';

            const inMonth = cellDay.getMonth() === viewMonth.getMonth();
            const iso = cellDay.toIsoDateString();
            const disabled = !isSelectable(cellDay, config, state.today);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.dataset.calendarDay = iso;
            btn.className = `flex ${config.sizeClass} items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800`;
            btn.textContent = String(cellDay.getDay());
            btn.setAttribute('role', 'gridcell');
            btn.setAttribute('aria-selected', isSelected(cellDay, state) ? 'true' : 'false');

            if (!inMonth) {
                btn.classList.add('opacity-40');
            }

            if (cellDay.isSameDay(state.today)) {
                btn.dataset.calendarToday = 'true';
            }

            if (isInRange(cellDay, state)) {
                btn.dataset.calendarInRange = 'true';
                btn.classList.add('bg-zinc-100', 'dark:bg-zinc-800');
            }

            if (isSelected(cellDay, state)) {
                btn.classList.add('bg-zinc-900', 'text-white', 'dark:bg-zinc-50', 'dark:text-zinc-900');
            }

            if (disabled) {
                btn.disabled = true;
            }

            td.appendChild(btn);
            row.appendChild(td);
        }

        tbody.appendChild(row);
    }

    table.appendChild(tbody);
    wrap.appendChild(table);

    return wrap;
}

/**
 * @param {DateValue} day
 * @param {{ selection: { start: DateValue | null, end: DateValue | null } }} state
 */
function isSelected(day, state) {
    if (state.selection.start && day.isSameDay(state.selection.start)) {
        return true;
    }

    return !!(state.selection.end && day.isSameDay(state.selection.end));
}

/**
 * @param {DateValue} day
 * @param {{ selection: { start: DateValue | null, end: DateValue | null } }} state
 */
function isInRange(day, state) {
    if (!state.selection.start || !state.selection.end) {
        return false;
    }

    return day.isBetween(state.selection.start, state.selection.end);
}

/**
 * @param {DateValue} day
 * @param {ReturnType<typeof readConfig>} config
 * @param {DateValue} today
 */
function isSelectable(day, config, today) {
    let min = config.min;
    let max = config.max;

    if (min === 'today') {
        min = today;
    }

    if (max === 'today') {
        max = today;
    }

    if (min instanceof DateValue && day.isBefore(min)) {
        return false;
    }

    if (max instanceof DateValue && day.isAfter(max)) {
        return false;
    }

    if (config.unavailable.includes(day.toIsoDateString())) {
        return false;
    }

    return true;
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCalendars());
    } else {
        initCalendars();
    }
}
