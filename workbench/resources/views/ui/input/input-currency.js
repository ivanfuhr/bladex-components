/**
 * Stencil — currency input (formatted display, float hidden value).
 */

const INPUT_CURRENCY_SELECTOR = '[data-input-currency]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initInputCurrencies(root = document) {
    root.querySelectorAll(INPUT_CURRENCY_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindInputCurrency(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindInputCurrency(root) {
    const mode = root.getAttribute('data-input-currency-mode') || 'cents';
    const locale = root.getAttribute('data-input-currency-locale') || 'en-US';
    const currency = root.getAttribute('data-input-currency-currency') || 'USD';
    const precision = parseInt(root.getAttribute('data-input-currency-precision') || '2', 10);

    /** @type {HTMLInputElement | null} */
    const hidden = root.querySelector('[data-input-currency-value]');
    /** @type {HTMLInputElement | null} */
    const display = root.querySelector('[data-input-currency-display]');

    if (!(hidden instanceof HTMLInputElement) || !(display instanceof HTMLInputElement)) {
        return;
    }

    if (display.readOnly || display.disabled) {
        return;
    }

    const scale = 10 ** precision;

    const formatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency,
        minimumFractionDigits: precision,
        maximumFractionDigits: precision,
    });

    /**
     * @param {number} minorUnits
     */
    function minorToFloat(minorUnits) {
        return minorUnits / scale;
    }

    /**
     * @param {number} amount
     */
    function floatToMinor(amount) {
        return Math.round(amount * scale);
    }

    /**
     * @param {number} minorUnits
     */
    function syncFromMinor(minorUnits) {
        if (minorUnits <= 0) {
            hidden.value = '';
            display.value = '';

            return;
        }

        const floatValue = minorToFloat(minorUnits);
        hidden.value = floatValue.toFixed(precision);
        display.value = formatter.format(floatValue);
    }

    function readInitialMinor() {
        const raw = hidden.value.trim();

        if (raw === '') {
            return 0;
        }

        const parsed = Number.parseFloat(raw);

        if (!Number.isFinite(parsed)) {
            return 0;
        }

        return Math.max(0, floatToMinor(parsed));
    }

    let minorUnits = readInitialMinor();

    if (mode !== 'cents') {
        return;
    }

    display.addEventListener('keydown', (event) => {
        if (event.ctrlKey || event.metaKey || event.altKey) {
            return;
        }

        const key = event.key;

        if (
            key === 'Tab' ||
            key === 'Escape' ||
            key.startsWith('Arrow') ||
            key === 'Home' ||
            key === 'End'
        ) {
            return;
        }

        if (key === 'Backspace' || key === 'Delete') {
            event.preventDefault();
            minorUnits = Math.floor(minorUnits / 10);
            syncFromMinor(minorUnits);

            return;
        }

        if (key.length === 1 && key >= '0' && key <= '9') {
            event.preventDefault();
            const digit = key.charCodeAt(0) - 48;
            minorUnits = minorUnits * 10 + digit;
            syncFromMinor(minorUnits);
        } else if (key.length === 1) {
            event.preventDefault();
        }
    });

    display.addEventListener('paste', (event) => {
        event.preventDefault();
        const text = event.clipboardData?.getData('text') ?? '';
        const digits = text.replace(/\D/g, '');

        if (digits === '') {
            return;
        }

        minorUnits = Number.parseInt(digits, 10);

        if (!Number.isFinite(minorUnits)) {
            minorUnits = 0;
        }

        syncFromMinor(minorUnits);
    });

    display.addEventListener('input', (event) => {
        event.preventDefault();
    });
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initInputCurrencies(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initInputCurrencies());
    } else {
        initInputCurrencies();
    }
}
