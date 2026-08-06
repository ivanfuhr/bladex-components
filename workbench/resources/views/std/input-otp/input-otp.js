/**
 * Std Components — accessible OTP / PIN input (vanilla JS, no Alpine).
 */

const INPUT_OTP_SELECTOR = '[data-input-otp]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initInputOtps(root = document) {
    root.querySelectorAll(INPUT_OTP_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindInputOtp(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindInputOtp(root) {
    /** @type {HTMLInputElement | null} */
    const hiddenInput = root.querySelector('[data-input-otp-hidden-input]');

    if (!(hiddenInput instanceof HTMLInputElement)) {
        return;
    }

    const mode =
        root.getAttribute('data-input-otp-mode') === 'alphanumeric' ? 'alphanumeric' : 'numeric';

    const lengthAttr = Number.parseInt(root.getAttribute('data-input-otp-length') ?? '', 10);

    /**
     * @returns {HTMLInputElement[]}
     */
    function slots() {
        return Array.from(root.querySelectorAll('[data-input-otp-slot]'))
            .filter((node) => node instanceof HTMLInputElement)
            .sort((a, b) => {
                const ai = Number.parseInt(a.dataset.index ?? '', 10);
                const bi = Number.parseInt(b.dataset.index ?? '', 10);

                return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
            });
    }

    const slotElements = slots();
    const length = Number.isFinite(lengthAttr) && lengthAttr > 0 ? lengthAttr : slotElements.length;

    if (slotElements.length === 0) {
        return;
    }

    /**
     * @param {string} char
     */
    function isAllowedChar(char) {
        if (mode === 'numeric') {
            return /^[0-9]$/.test(char);
        }

        return /^[a-zA-Z0-9]$/.test(char);
    }

    /**
     * @param {string} raw
     */
    function sanitize(raw) {
        return Array.from(raw)
            .map((char) => (mode === 'alphanumeric' ? char.toUpperCase() : char))
            .filter(isAllowedChar)
            .join('')
            .slice(0, length);
    }

    function dispatchValueEvents(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function isDisabled() {
        return root.hasAttribute('data-disabled') || hiddenInput.disabled;
    }

    /**
     * @param {{ dispatch?: boolean }} [options]
     */
    function syncFromSlots(options = {}) {
        const value = slotElements
            .slice(0, length)
            .map((slot) => slot.value.slice(0, 1))
            .join('');

        const previous = hiddenInput.value;
        hiddenInput.value = value;
        root.dataset.complete = value.length === length ? 'true' : 'false';

        if (options.dispatch !== false && previous !== value) {
            dispatchValueEvents(hiddenInput);
        }
    }

    /**
     * @param {string} value
     * @param {{ focusIndex?: number | null, dispatch?: boolean }} [options]
     */
    function applyValue(value, options = {}) {
        const next = sanitize(value);

        slotElements.forEach((slot, index) => {
            slot.value = next.charAt(index) ?? '';
        });

        syncFromSlots({ dispatch: options.dispatch });

        if (typeof options.focusIndex === 'number') {
            const target =
                slotElements[Math.min(Math.max(options.focusIndex, 0), slotElements.length - 1)];
            target?.focus();
            target?.select();
        }
    }

    /**
     * @param {number} index
     */
    function focusSlot(index) {
        const target = slotElements[Math.min(Math.max(index, 0), slotElements.length - 1)];
        if (!target || target.disabled) {
            return;
        }

        target.focus();
        target.select();
    }

    slotElements.forEach((slot, index) => {
        slot.addEventListener('focus', () => {
            slot.select();
        });

        slot.addEventListener('click', () => {
            slot.select();
        });

        slot.addEventListener('paste', (event) => {
            if (isDisabled() || slot.disabled) {
                return;
            }

            event.preventDefault();

            const pasted = event.clipboardData?.getData('text') ?? '';
            const sanitized = sanitize(pasted);

            if (sanitized === '') {
                return;
            }

            const chars = Array.from(sanitized);
            const next = slotElements.map((item) => item.value.slice(0, 1));

            chars.forEach((char, offset) => {
                const targetIndex = index + offset;
                if (targetIndex < length) {
                    next[targetIndex] = char;
                }
            });

            applyValue(next.join(''), {
                focusIndex: Math.min(index + chars.length, length - 1),
            });
        });

        slot.addEventListener('input', () => {
            if (isDisabled() || slot.disabled) {
                return;
            }

            const raw = slot.value;
            const sanitized = sanitize(raw);

            if (sanitized === '') {
                slot.value = '';
                syncFromSlots();
                return;
            }

            if (raw.length > 1) {
                // Mobile OTP autofill / multi-char insert into one slot.
                const next = slotElements.map((item) => item.value.slice(0, 1));
                const chars = Array.from(sanitized);

                chars.forEach((char, offset) => {
                    const targetIndex = index + offset;
                    if (targetIndex < length) {
                        next[targetIndex] = char;
                    }
                });

                applyValue(next.join(''), {
                    focusIndex: Math.min(index + chars.length, length - 1),
                });

                return;
            }

            const char = sanitized.charAt(sanitized.length - 1);
            slot.value = char;
            syncFromSlots();

            if (index < length - 1) {
                focusSlot(index + 1);
            }
        });

        slot.addEventListener('keydown', (event) => {
            if (isDisabled() || slot.disabled) {
                return;
            }

            switch (event.key) {
                case 'Backspace':
                    event.preventDefault();

                    if (slot.value !== '') {
                        slot.value = '';
                        syncFromSlots();
                        break;
                    }

                    if (index > 0) {
                        const previous = slotElements[index - 1];
                        if (previous) {
                            previous.value = '';
                            syncFromSlots();
                            focusSlot(index - 1);
                        }
                    }
                    break;
                case 'Delete':
                    event.preventDefault();
                    slot.value = '';
                    syncFromSlots();
                    break;
                case 'ArrowLeft':
                    event.preventDefault();
                    focusSlot(index - 1);
                    break;
                case 'ArrowRight':
                    event.preventDefault();
                    focusSlot(index + 1);
                    break;
                case 'Home':
                    event.preventDefault();
                    focusSlot(0);
                    break;
                case 'End':
                    event.preventDefault();
                    focusSlot(length - 1);
                    break;
                default:
                    break;
            }
        });
    });

    // Seed slots from the hidden input when the server provided a value.
    if (hiddenInput.value !== '') {
        applyValue(hiddenInput.value, { dispatch: false });
    } else {
        syncFromSlots({ dispatch: false });
    }
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initInputOtps(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initInputOtps());
    } else {
        initInputOtps();
    }
}
