/**
 * @param {string} dateStr
 */
export function parseDateString(dateStr) {
    const match = dateStr.match(
        /^(\d{4})(?:-(\d{2}))?(?:-(\d{2}))?(?:T(\d{2}):(\d{2}):(\d{2})(?:\.(\d+))?(Z)?)?$/,
    );

    if (!match) {
        throw new Error('Invalid date format');
    }

    return {
        year: match[1] ? parseInt(match[1], 10) : null,
        month: match[2] ? parseInt(match[2], 10) : null,
        day: match[3] ? parseInt(match[3], 10) : null,
        hour: match[4] ? parseInt(match[4], 10) : 0,
        minute: match[5] ? parseInt(match[5], 10) : 0,
        second: match[6] ? parseInt(match[6], 10) : 0,
        millisecond: match[7] ? parseInt(match[7].padEnd(3, '0'), 10) : 0,
        utc: !!match[8],
    };
}

/**
 * @param {string} value
 */
export function dateFromString(value) {
    if (value instanceof Date) {
        return value;
    }

    const { year, month, day, hour, minute, second, millisecond } = parseDateString(value);

    return new Date(Date.UTC(year, month - 1, day, hour, minute, second, millisecond));
}

/**
 * @param {Date} date
 */
export function toIsoDateTimeString(date) {
    const pad = (n) => String(n).padStart(2, '0');

    return `${date.getUTCFullYear()}-${pad(date.getUTCMonth() + 1)}-${pad(date.getUTCDate())}T${pad(date.getUTCHours())}:${pad(date.getUTCMinutes())}:${pad(date.getUTCSeconds())}Z`;
}

/**
 * @param {string} rangeValue start/end with /
 */
export function parseRangeValue(rangeValue) {
    if (!rangeValue || !rangeValue.includes('/')) {
        return { start: null, end: null };
    }

    const [start, end] = rangeValue.split('/');

    return { start: start || null, end: end || null };
}

/**
 * @param {string | null} start
 * @param {string | null} end
 */
export function formatRangeValue(start, end) {
    if (!start || !end) {
        return '';
    }

    return `${start}/${end}`;
}
