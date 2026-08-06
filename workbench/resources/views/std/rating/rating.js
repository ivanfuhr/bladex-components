/**
 * Std Components — star rating input (vanilla JS, no Alpine).
 */

const RATING_SELECTOR = '[data-rating]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initRatings(root = document) {
    root.querySelectorAll(RATING_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindRating(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindRating(root) {
    /** @type {HTMLInputElement | null} */
    const hiddenInput = root.querySelector('[data-rating-hidden-input]');
    const stars = Array.from(root.querySelectorAll('[data-rating-star]')).filter(
        (node) => node instanceof HTMLButtonElement,
    );
    const max = Number.parseInt(root.getAttribute('data-rating-max') ?? '5', 10);
    const disabled = root.hasAttribute('data-disabled');

    if (!(hiddenInput instanceof HTMLInputElement) || stars.length === 0) {
        return;
    }

    /**
     * @param {HTMLElement} target
     */
    function dispatchChange(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @param {number} value
     * @param {{ focus?: boolean }} [options]
     */
    function setValue(value, options = {}) {
        const clamped = Math.max(0, Math.min(max, value));
        hiddenInput.value = String(clamped);

        stars.forEach((star) => {
            const starValue = Number.parseInt(star.getAttribute('data-rating-value') ?? '0', 10);
            const active = starValue <= clamped;
            const checked = starValue === clamped;

            star.classList.toggle('!text-amber-700', active);
            star.classList.toggle('dark:!text-amber-400', active);
            star.setAttribute('aria-checked', checked ? 'true' : 'false');

            const isTabStop = checked || (clamped === 0 && starValue === 1);
            star.tabIndex = isTabStop ? 0 : -1;

            if (options.focus && isTabStop) {
                star.focus();
            }
        });

        dispatchChange(hiddenInput);
    }

    stars.forEach((star) => {
        star.addEventListener('click', (event) => {
            event.preventDefault();

            if (disabled) {
                return;
            }

            const value = Number.parseInt(star.getAttribute('data-rating-value') ?? '0', 10);
            const current = Number.parseInt(hiddenInput.value || '0', 10);

            if (current === value) {
                setValue(0, { focus: true });
            } else {
                setValue(value, { focus: true });
            }
        });

        star.addEventListener('keydown', (event) => {
            if (disabled) {
                return;
            }

            const current = Number.parseInt(hiddenInput.value || '0', 10);
            const starValue = Number.parseInt(star.getAttribute('data-rating-value') ?? '0', 10);

            switch (event.key) {
                case 'ArrowRight':
                case 'ArrowUp':
                    event.preventDefault();
                    setValue(Math.min(max, (current || starValue) + 1), { focus: true });
                    break;
                case 'ArrowLeft':
                case 'ArrowDown':
                    event.preventDefault();
                    setValue(Math.max(1, (current || starValue) - 1), { focus: true });
                    break;
                case 'Home':
                    event.preventDefault();
                    setValue(1, { focus: true });
                    break;
                case 'End':
                    event.preventDefault();
                    setValue(max, { focus: true });
                    break;
                case ' ':
                case 'Enter':
                    event.preventDefault();
                    if (current === starValue) {
                        setValue(0, { focus: true });
                    } else {
                        setValue(starValue, { focus: true });
                    }
                    break;
                default:
                    break;
            }
        });
    });
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initRatings(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initRatings());
    } else {
        initRatings();
    }
}
