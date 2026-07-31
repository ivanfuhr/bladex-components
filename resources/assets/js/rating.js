/**
 * Stencil — star rating input (vanilla JS, no Alpine).
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
    const stars = root.querySelectorAll('[data-rating-star]');
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
     */
    function setValue(value) {
        const clamped = Math.max(0, Math.min(max, value));
        hiddenInput.value = String(clamped);
        root.setAttribute('aria-valuenow', String(clamped));

        stars.forEach((star) => {
            if (!(star instanceof HTMLElement)) {
                return;
            }

            const starValue = Number.parseInt(star.getAttribute('data-rating-value') ?? '0', 10);
            const active = starValue <= clamped;
            star.classList.toggle('!text-amber-400', active);
            star.classList.toggle('dark:!text-amber-400', active);
        });

        dispatchChange(hiddenInput);
    }

    stars.forEach((star) => {
        if (!(star instanceof HTMLButtonElement)) {
            return;
        }

        star.addEventListener('click', (event) => {
            event.preventDefault();

            if (disabled) {
                return;
            }

            const value = Number.parseInt(star.getAttribute('data-rating-value') ?? '0', 10);
            const current = Number.parseInt(hiddenInput.value || '0', 10);

            if (current === value) {
                setValue(0);
            } else {
                setValue(value);
            }
        });
    });

    root.addEventListener('keydown', (event) => {
        if (disabled) {
            return;
        }

        const current = Number.parseInt(hiddenInput.value || '0', 10);

        switch (event.key) {
            case 'ArrowRight':
            case 'ArrowUp':
                event.preventDefault();
                setValue(current + 1);
                break;
            case 'ArrowLeft':
            case 'ArrowDown':
                event.preventDefault();
                setValue(current - 1);
                break;
            case 'Home':
                event.preventDefault();
                setValue(0);
                break;
            case 'End':
                event.preventDefault();
                setValue(max);
                break;
            default:
                break;
        }
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

    initRatings(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initRatings());
    } else {
        initRatings();
    }
}
