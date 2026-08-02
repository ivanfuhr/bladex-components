/**
 * Stencil — accessible toggle group (vanilla JS, no Alpine).
 */

const GROUP_SELECTOR = '[data-toggle-group]';
const ITEM_SELECTOR = '[data-toggle-group-item]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initToggleGroups(root = document) {
    root.querySelectorAll(GROUP_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindToggleGroup(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindToggleGroup(root) {
    const type = root.dataset.type === 'multiple' ? 'multiple' : 'single';
    const orientation = root.dataset.orientation === 'vertical' ? 'vertical' : 'horizontal';

    /** @returns {HTMLButtonElement[]} */
    const items = () =>
        Array.from(root.querySelectorAll(ITEM_SELECTOR)).filter(
            (node) => node instanceof HTMLButtonElement && !node.disabled,
        );

    /**
     * @param {HTMLButtonElement} item
     * @param {boolean} selected
     */
    const setItemState = (item, selected) => {
        item.dataset.state = selected ? 'on' : 'off';

        if (type === 'single') {
            item.setAttribute('aria-checked', selected ? 'true' : 'false');
            item.tabIndex = selected ? 0 : -1;
            item.removeAttribute('aria-pressed');
        } else {
            item.setAttribute('aria-pressed', selected ? 'true' : 'false');
            item.tabIndex = 0;
            item.removeAttribute('aria-checked');
        }
    };

    /**
     * @returns {string[]}
     */
    const selectedValues = () =>
        items()
            .filter((item) => item.dataset.state === 'on')
            .map((item) => item.dataset.value)
            .filter((value) => typeof value === 'string');

    /**
     * @param {string[]} values
     */
    const sync = (values) => {
        const unique = [...new Set(values)];

        items().forEach((item) => {
            const value = item.dataset.value;
            setItemState(item, typeof value === 'string' && unique.includes(value));
        });

        if (type === 'single' && unique.length === 0) {
            const first = items()[0];

            if (first) {
                first.tabIndex = 0;
            }
        }

        root.dataset.value = unique.join(',');

        root.dispatchEvent(
            new CustomEvent('stencil:toggle-group:change', {
                bubbles: true,
                detail: {
                    type,
                    value: type === 'single' ? (unique[0] ?? null) : unique,
                },
            }),
        );
    };

    const initial = (root.dataset.value || '')
        .split(',')
        .map((value) => value.trim())
        .filter((value) => value !== '');

    if (initial.length > 0) {
        sync(type === 'single' ? [initial[0]] : initial);
    } else {
        sync(selectedValues());
    }

    root.addEventListener('click', (event) => {
        if (root.dataset.disabled === 'true') {
            return;
        }

        const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR) : null;

        if (!(item instanceof HTMLButtonElement) || !root.contains(item) || item.disabled) {
            return;
        }

        const value = item.dataset.value;

        if (typeof value !== 'string') {
            return;
        }

        if (type === 'single') {
            const current = selectedValues()[0] ?? null;
            sync(current === value ? [] : [value]);
        } else {
            const current = selectedValues();
            sync(
                current.includes(value)
                    ? current.filter((entry) => entry !== value)
                    : [...current, value],
            );
        }
    });

    root.addEventListener('keydown', (event) => {
        const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR) : null;

        if (!(item instanceof HTMLButtonElement) || !root.contains(item)) {
            return;
        }

        const enabled = items();
        const index = enabled.indexOf(item);
        const nextKey = orientation === 'vertical' ? 'ArrowDown' : 'ArrowRight';
        const prevKey = orientation === 'vertical' ? 'ArrowUp' : 'ArrowLeft';

        let nextIndex = index;

        if (event.key === nextKey) {
            nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
        } else if (event.key === prevKey) {
            nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
        } else if (event.key === 'Home') {
            nextIndex = 0;
        } else if (event.key === 'End') {
            nextIndex = enabled.length - 1;
        } else if (event.key === ' ' || event.key === 'Enter') {
            if (type === 'single' && event.key === ' ') {
                event.preventDefault();
                item.click();
            }

            return;
        } else {
            return;
        }

        event.preventDefault();
        const next = enabled[nextIndex];

        if (next instanceof HTMLButtonElement) {
            next.focus();

            if (type === 'single') {
                const value = next.dataset.value;

                if (typeof value === 'string') {
                    sync([value]);
                }
            }
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

    initToggleGroups(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initToggleGroups());
    } else {
        initToggleGroups();
    }
}
