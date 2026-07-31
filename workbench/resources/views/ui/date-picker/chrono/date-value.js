/**
 * Calendar date stored as UTC midnight (Flux-style) to avoid DST grid bugs.
 */
export class DateValue {
    /**
     * @param {number} year
     * @param {number} month 1-12
     * @param {number} day
     */
    constructor(year, month, day = 1) {
        this._date = new Date(Date.UTC(year, month - 1, day));
    }

    /**
     * @param {DateValue | null} min
     * @param {DateValue | null} max
     */
    isBetween(min, max) {
        if (!min && !max) {
            return true;
        }
        if (!min) {
            return this._date <= max._date;
        }
        if (!max) {
            return this._date >= min._date;
        }

        return this._date >= min._date && this._date <= max._date;
    }

    /**
     * @param {DateValue | null} date
     */
    isSameDay(date) {
        if (!date) {
            return false;
        }

        return (
            this._date.getUTCDate() === date._date.getUTCDate() &&
            this._date.getUTCMonth() === date._date.getUTCMonth() &&
            this._date.getUTCFullYear() === date._date.getUTCFullYear()
        );
    }

    /**
     * @param {DateValue} date
     */
    isBefore(date) {
        return this._date < date._date;
    }

    /**
     * @param {DateValue} date
     */
    isAfter(date) {
        return this._date > date._date;
    }

    incrementDays(days) {
        const copy = this.getCopy();
        copy._date.setUTCDate(copy._date.getUTCDate() + days);

        return copy;
    }

    addMonths(months) {
        const copy = this.getCopy();
        copy._date.setUTCMonth(copy._date.getUTCMonth() + months);

        return copy;
    }

    addDays(days) {
        return this.incrementDays(days);
    }

    getYear() {
        return this._date.getUTCFullYear();
    }

    getMonth() {
        return this._date.getUTCMonth() + 1;
    }

    getPaddedMonth() {
        return String(this.getMonth()).padStart(2, '0');
    }

    getDay() {
        return this._date.getUTCDate();
    }

    getPaddedDay() {
        return String(this.getDay()).padStart(2, '0');
    }

    getDate() {
        return this._date;
    }

    getCopy() {
        return new DateValue(this.getYear(), this.getMonth(), this.getDay());
    }

    getDayOfWeek() {
        return this._date.getUTCDay();
    }

    getDaysInMonth() {
        return new DateValue(this.getYear(), this.getMonth() + 1, 0).getDay();
    }

    getFirstDayOfMonth() {
        return new DateValue(this.getYear(), this.getMonth(), 1).getDayOfWeek();
    }

    toIsoDateString() {
        return [this.getYear(), this.getPaddedMonth(), this.getPaddedDay()].join('-');
    }

    /**
     * @param {string | null | undefined} isoString
     */
    static fromIsoDateString(isoString) {
        if (!isoString) {
            return null;
        }

        const datePart = isoString.split('T')[0] ?? '';
        const [year, month, day] = datePart.split('-').map(Number);

        if (!year || !month || !day) {
            return null;
        }

        return new DateValue(year, month, day);
    }

    /**
     * @param {Date} date
     */
    static fromDate(date) {
        if (!date) {
            return null;
        }

        return new DateValue(date.getFullYear(), date.getMonth() + 1, date.getDate());
    }

    static today() {
        return DateValue.fromDate(new Date());
    }
}
