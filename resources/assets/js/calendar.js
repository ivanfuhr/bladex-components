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

        if (element.closest('[data-date-picker], [data-datetime-picker]')) {
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
            render: () => {},
        };
    }

    root.dataset.calendarBound = 'true';

    const config = readConfig(root);
    const state = createState(root, config);
    const initialValue = root.dataset.calendarValue ?? '';
    const deferRender =
        root.closest('[data-date-picker-panel], [data-datetime-picker-panel]') !== null;

    const monthsEl = root.querySelector(':scope > [data-calendar-months-container]');
    const prevBtn = root.querySelector('[data-calendar-prev]');
    const nextBtn = root.querySelector('[data-calendar-next]');
    const todayBtn = root.querySelector('[data-calendar-today]');
    const monthLabel = root.querySelector('[data-calendar-month-label]');
    const headerEl = root.querySelector('[data-calendar-header]');

    if (monthsEl instanceof HTMLElement) {
        monthsEl.style.display = 'flex';
        monthsEl.style.gap = '1rem';
    }

    if (headerEl instanceof HTMLElement) {
        headerEl.style.display = 'flex';
        headerEl.style.alignItems = 'center';
        headerEl.style.justifyContent = 'space-between';
        headerEl.style.gap = '0.5rem';
        headerEl.style.marginBottom = '0.5rem';
    }

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
            if (config.monthCount > 1) {
                monthLabel.textContent = '';
                monthLabel.style.display = 'none';
            } else {
                monthLabel.style.display = '';
                const first = state.viewMonth;
                monthLabel.textContent = formatDateValue(first, config.locale, {
                    month: 'long',
                    year: 'numeric',
                });
            }
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

    function focusedDay() {
        return state.selection.focus ?? state.selection.start ?? state.selection.end ?? state.today;
    }

    function ensureFocusVisible(day) {
        const viewStart = new DateValue(state.viewMonth.getYear(), state.viewMonth.getMonth(), 1);
        const lastMonth = state.viewMonth.addMonths(config.monthCount - 1);
        const viewEnd = new DateValue(
            lastMonth.getYear(),
            lastMonth.getMonth(),
            lastMonth.getDaysInMonth(),
        );

        if (day.isBefore(viewStart)) {
            state.viewMonth = new DateValue(day.getYear(), day.getMonth(), 1);
        } else if (day.isAfter(viewEnd)) {
            state.viewMonth = new DateValue(day.getYear(), day.getMonth(), 1).addMonths(
                -(config.monthCount - 1),
            );
        }
    }

    function focusActiveDayButton() {
        const iso = focusedDay().toIsoDateString();
        const button =
            root.querySelector(`[data-calendar-day="${iso}"][tabindex="0"]`) ??
            root.querySelector(`[data-calendar-day="${iso}"]:not([disabled])`);

        if (button instanceof HTMLButtonElement) {
            button.focus();
        }
    }

    function moveFocusTo(day) {
        state.selection.focus = day;
        ensureFocusVisible(day);
        render();
        focusActiveDayButton();
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
            state.selection.focus = state.today.getCopy();
            render();
            focusActiveDayButton();

            return;
        }

        state.selection.focus = state.today.getCopy();
        selectDay(state.today, state, config);
        render();
        focusActiveDayButton();

        if (!config.withConfirmation && shouldCommitSelection(state, config)) {
            commitSelection();
        }
    });

    root.addEventListener('click', (event) => {
        const target =
            event.target instanceof Element ? event.target.closest('[data-calendar-day]') : null;

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

        state.selection.focus = day;
        selectDay(day, state, config);
        render();
        focusActiveDayButton();

        if (!config.withConfirmation && shouldCommitSelection(state, config)) {
            commitSelection();
        }
    });

    root.addEventListener('keydown', (event) => {
        const dayTarget =
            event.target instanceof Element ? event.target.closest('[data-calendar-day]') : null;

        if (!dayTarget && event.target !== root) {
            return;
        }

        const navigationKeys = [
            'ArrowLeft',
            'ArrowRight',
            'ArrowUp',
            'ArrowDown',
            'Home',
            'End',
            'PageUp',
            'PageDown',
        ];

        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();

            const day = focusedDay();

            if (!isSelectable(day, config, state.today)) {
                return;
            }

            selectDay(day, state, config);
            state.selection.focus = day;
            render();
            focusActiveDayButton();

            if (!config.withConfirmation && shouldCommitSelection(state, config)) {
                commitSelection();
            }

            return;
        }

        if (!navigationKeys.includes(event.key)) {
            return;
        }

        event.preventDefault();

        const base = focusedDay();
        let next = base;

        if (event.key === 'ArrowLeft') {
            next = base.incrementDays(-1);
        } else if (event.key === 'ArrowRight') {
            next = base.incrementDays(1);
        } else if (event.key === 'ArrowUp') {
            next = base.incrementDays(-7);
        } else if (event.key === 'ArrowDown') {
            next = base.incrementDays(7);
        } else if (event.key === 'Home') {
            const offset = (base.getDayOfWeek() - config.startDay + 7) % 7;
            next = base.incrementDays(-offset);
        } else if (event.key === 'End') {
            const offset = (base.getDayOfWeek() - config.startDay + 7) % 7;
            next = base.incrementDays(6 - offset);
        } else if (event.key === 'PageUp') {
            next = base.addMonths(event.shiftKey ? -12 : -1);
        } else if (event.key === 'PageDown') {
            next = base.addMonths(event.shiftKey ? 12 : 1);
        }

        moveFocusTo(next);
    });

    root.addEventListener('calendar:confirm', () => {
        commitSelection();
    });

    root.addEventListener('calendar:cancel', () => {
        loadInitialSelection(state, config, root.dataset.calendarValue ?? initialValue);
        render();
    });

    if (!deferRender) {
        render();
    }

    return {
        getValue: () => serializeSelection(state, config.mode),
        setValue: (value) => {
            loadValueIntoState(value, state, config.mode);
            render();
        },
        confirm: commitSelection,
        render,
    };
}

/**
 * @param {HTMLElement} root
 */
function readConfig(root) {
    const mode = root.dataset.calendarMode === 'range' ? 'range' : 'single';
    const monthCount = Math.max(1, parseInt(root.dataset.calendarMonthCount ?? '1', 10) || 1);

    return {
        mode,
        monthCount,
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
        fixedWeeks: root.hasAttribute('data-calendar-fixed-weeks') || monthCount > 1,
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
    state.selection.focus = null;

    if (!value) {
        return;
    }

    if (mode === 'range') {
        const { start, end } = parseRangeValue(value);
        state.selection.start = DateValue.fromIsoDateString(start ?? '');
        state.selection.end = DateValue.fromIsoDateString(end ?? '');
        state.selection.focus = state.selection.end ?? state.selection.start;

        return;
    }

    state.selection.start = DateValue.fromIsoDateString(value.split(',')[0] ?? value);
    state.selection.focus = state.selection.start;
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
 * @param {{ today: DateValue, selection: { start: DateValue | null, end: DateValue | null, focus: DateValue | null } }} state
 */
function buildMonthTable(viewMonth, config, state) {
    const wrap = document.createElement('div');
    wrap.className = 'calendar__month shrink-0';
    wrap.style.width = '17.5rem';
    wrap.style.flexShrink = '0';

    const focusDay =
        state.selection.focus ?? state.selection.start ?? state.selection.end ?? state.today;

    if (config.monthCount > 1) {
        const monthTitle = document.createElement('div');
        monthTitle.className =
            'calendar__month-title mb-2 text-center text-sm font-medium leading-5 text-zinc-800 dark:text-zinc-50';
        monthTitle.textContent = formatDateValue(viewMonth, config.locale, {
            month: 'long',
            year: 'numeric',
        });
        wrap.appendChild(monthTitle);
    }

    const grid = document.createElement('div');
    grid.setAttribute('role', 'grid');
    grid.className = 'calendar__grid';
    grid.style.display = 'grid';
    grid.style.gridTemplateColumns = 'repeat(7, minmax(0, 1fr))';
    grid.style.gap = '2px';

    for (let i = 0; i < 7; i++) {
        const header = document.createElement('div');
        header.setAttribute('role', 'columnheader');
        header.className = `flex ${config.sizeClass} items-center justify-center font-medium text-zinc-500`;
        const idx = (i + config.startDay) % 7;
        const date = new Date(2024, 0, 7 + idx);
        header.textContent = new Intl.DateTimeFormat(config.locale, { weekday: 'narrow' }).format(
            date,
        );
        grid.appendChild(header);
    }

    const first = new DateValue(viewMonth.getYear(), viewMonth.getMonth(), 1);
    let cursor = first.incrementDays(-((first.getDayOfWeek() - config.startDay + 7) % 7));

    const weeks = config.fixedWeeks ? 6 : weeksInMonth(viewMonth, config.startDay);

    for (let w = 0; w < weeks; w++) {
        for (let d = 0; d < 7; d++) {
            const cellDay = cursor;
            cursor = cursor.incrementDays(1);

            const cell = document.createElement('div');
            cell.className = 'p-0';
            cell.setAttribute('role', 'gridcell');

            const inMonth = cellDay.getMonth() === viewMonth.getMonth();
            const iso = cellDay.toIsoDateString();
            const disabled = !isSelectable(cellDay, config, state.today);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.dataset.calendarDay = iso;
            btn.className = `flex ${config.sizeClass} w-full items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800`;
            btn.textContent = String(cellDay.getDay());
            btn.setAttribute(
                'aria-label',
                formatDateValue(cellDay, config.locale, {
                    weekday: 'long',
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                }),
            );
            btn.setAttribute('aria-selected', isSelected(cellDay, state) ? 'true' : 'false');
            btn.tabIndex = !disabled && inMonth && cellDay.isSameDay(focusDay) ? 0 : -1;

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
                btn.classList.add(
                    'bg-zinc-900',
                    'text-white',
                    'dark:bg-zinc-50',
                    'dark:text-zinc-900',
                );
            }

            if (disabled) {
                btn.disabled = true;
            }

            cell.appendChild(btn);
            grid.appendChild(cell);
        }
    }

    wrap.appendChild(grid);

    return wrap;
}

/**
 * @param {DateValue} viewMonth
 * @param {number} startDay
 */
function weeksInMonth(viewMonth, startDay) {
    const first = new DateValue(viewMonth.getYear(), viewMonth.getMonth(), 1);
    const padding = (first.getDayOfWeek() - startDay + 7) % 7;
    const total = padding + first.getDaysInMonth();

    return Math.ceil(total / 7);
}

/**
 * @param {{ selection: { start: DateValue | null, end: DateValue | null } }} state
 * @param {ReturnType<typeof readConfig>} config
 */
function shouldCommitSelection(state, config) {
    if (config.mode === 'range') {
        return !!(state.selection.start && state.selection.end);
    }

    return !!state.selection.start;
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

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initCalendars(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCalendars());
    } else {
        initCalendars();
    }
}
