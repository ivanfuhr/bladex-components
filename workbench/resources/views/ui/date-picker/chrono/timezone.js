import { DateValue } from './date-value.js';

/**
 * @param {string} timeZone IANA timezone
 */
export function todayInTimeZone(timeZone) {
    const formatter = new Intl.DateTimeFormat('en-US', {
        timeZone,
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    });

    const parts = formatter.formatToParts(new Date());
    const year = Number(parts.find((p) => p.type === 'year')?.value);
    const month = Number(parts.find((p) => p.type === 'month')?.value);
    const day = Number(parts.find((p) => p.type === 'day')?.value);

    return new DateValue(year, month, day);
}

/**
 * @param {DateValue} dateValue
 * @param {string} locale
 * @param {Intl.DateTimeFormatOptions} options
 */
export function formatDateValue(dateValue, locale, options = {}) {
    return new Intl.DateTimeFormat(locale, {
        ...options,
        timeZone: 'UTC',
    }).format(dateValue.getDate());
}

/**
 * Format a calendar date (YYYY-MM-DD) for the trigger label.
 *
 * @param {string} isoDate
 * @param {string} locale
 */
export function formatDateLabel(isoDate, locale) {
    if (! isoDate) {
        return '';
    }

    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(isoDate);

    if (! match) {
        return isoDate;
    }

    const date = new Date(Date.UTC(Number(match[1]), Number(match[2]) - 1, Number(match[3])));

    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        timeZone: 'UTC',
    }).format(date);
}

/**
 * Format an ISO datetime for the trigger label.
 *
 * @param {string} isoDatetime
 * @param {string} locale
 * @param {string} timeZone
 * @param {boolean} withSeconds
 */
export function formatDateTimeLabel(isoDatetime, locale, timeZone, withSeconds = false) {
    if (! isoDatetime) {
        return '';
    }

    const date = new Date(isoDatetime);

    if (Number.isNaN(date.getTime())) {
        return isoDatetime;
    }

    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        second: withSeconds ? '2-digit' : undefined,
        timeZone,
    }).format(date);
}

/**
 * Format a wall-clock time (HH:mm or HH:mm:ss) for labels.
 * Time-only values are timezone-independent — keep them on a UTC anchor so the
 * hour/minute never shift with the browser offset.
 *
 * @param {string} time HH:mm or HH:mm:ss
 * @param {string} locale
 * @param {string} [_timeZone] retained for call-site compatibility
 * @param {boolean} withSeconds
 */
export function formatTimeLabel(time, locale, _timeZone, withSeconds = false) {
    if (! time) {
        return '';
    }

    const [h, m, s] = time.split(':').map((v) => parseInt(v, 10) || 0);
    const date = new Date(Date.UTC(1970, 0, 1, h, m, s || 0));

    return new Intl.DateTimeFormat(locale, {
        hour: 'numeric',
        minute: '2-digit',
        second: withSeconds ? '2-digit' : undefined,
        timeZone: 'UTC',
    }).format(date);
}
