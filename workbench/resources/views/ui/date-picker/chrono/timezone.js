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
 * @param {string} time HH:mm or HH:mm:ss
 * @param {string} locale
 * @param {string} timeZone
 * @param {boolean} withSeconds
 */
export function formatTimeLabel(time, locale, timeZone, withSeconds = false) {
    const [h, m, s] = time.split(':').map((v) => parseInt(v, 10) || 0);
    const date = new Date();
    date.setHours(h, m, s || 0, 0);

    return new Intl.DateTimeFormat(locale, {
        hour: 'numeric',
        minute: '2-digit',
        second: withSeconds ? '2-digit' : undefined,
        timeZone,
    }).format(date);
}
