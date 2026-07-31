/**
 * Stencil — filterable combobox / autocomplete (vanilla JS, no Alpine).
 */

const COMBOBOX_SELECTOR = '[data-combobox]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initComboboxes(root = document) {
    root.querySelectorAll(COMBOBOX_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindCombobox(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindCombobox(root) {
    const input = root.querySelector('[data-combobox-input]');
    const toggle = root.querySelector('[data-combobox-toggle]');
    const content = root.querySelector('[data-combobox-content]');
    const emptyEl = root.querySelector('[data-combobox-empty]');
    /** @type {HTMLInputElement | null} */
    const hiddenInput = root.querySelector('[data-combobox-hidden-input]');
    const chevron = root.querySelector('[data-combobox-chevron]');

    if (!(input instanceof HTMLInputElement) || !(content instanceof HTMLElement)) {
        return;
    }

    if (!(hiddenInput instanceof HTMLInputElement)) {
        return;
    }

    const portalMarker = document.createComment('stencil-combobox-portal');
    let portalInserted = false;

    const options = () =>
        Array.from(content.querySelectorAll('[data-combobox-item]')).filter(
            (node) => node instanceof HTMLElement,
        );

    const visibleEnabledOptions = () =>
        options().filter(
            (el) => !el.hidden && !el.hasAttribute('data-disabled'),
        );

    let open = false;
    let activeIndex = -1;
    /** @type {string} */
    let committedLabel = '';

    function dispatchValueEvents(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @param {HTMLElement} el
     */
    function optionLabel(el) {
        const label = el.querySelector('[data-combobox-item-label]');
        if (label instanceof HTMLElement) {
            return label.textContent?.trim() ?? '';
        }

        return el.textContent?.trim() ?? '';
    }

    /**
     * @param {string} value
     */
    function syncOptionSelection(value) {
        options().forEach((item) => {
            item.setAttribute(
                'aria-selected',
                item.getAttribute('data-value') === value ? 'true' : 'false',
            );
        });
    }

    function ensurePortal() {
        if (content.parentElement === document.body) {
            return;
        }

        const parent = content.parentElement;
        if (parent && !portalInserted) {
            parent.insertBefore(portalMarker, content);
            portalInserted = true;
        }

        document.body.appendChild(content);
        content.dataset.comboboxPortaled = 'true';
    }

    function positionContent() {
        ensurePortal();

        const wrap = root.querySelector('[data-combobox-input-wrap]');
        const anchor =
            wrap instanceof HTMLElement ? wrap : input;

        const rect = anchor.getBoundingClientRect();
        const gap = 6;
        const viewportPadding = 8;

        content.style.position = 'fixed';
        content.style.left = `${Math.max(viewportPadding, rect.left)}px`;
        content.style.width = `${rect.width}px`;
        content.style.minWidth = `${rect.width}px`;
        content.style.zIndex = '200';

        const wasHidden = content.hidden;
        content.hidden = false;
        content.style.visibility = 'hidden';
        content.style.pointerEvents = 'none';
        const panelHeight = content.offsetHeight;
        content.style.visibility = '';
        content.style.pointerEvents = '';
        content.hidden = wasHidden;

        let top = rect.bottom + gap;
        const maxBottom = window.innerHeight - viewportPadding;

        if (top + panelHeight > maxBottom) {
            const topAbove = rect.top - gap - panelHeight;
            if (topAbove >= viewportPadding) {
                top = topAbove;
            } else {
                content.style.maxHeight = `${maxBottom - top}px`;
            }
        } else {
            content.style.maxHeight = '';
        }

        content.style.top = `${top}px`;
    }

    /**
     * @param {string} query
     */
    function applyFilter(query) {
        const q = query.trim().toLowerCase();
        let visibleCount = 0;

        options().forEach((el) => {
            const match =
                q === '' || optionLabel(el).toLowerCase().includes(q);
            el.hidden = !match;
            if (match) {
                visibleCount += 1;
            }
        });

        content.querySelectorAll('[data-combobox-group]').forEach((group) => {
            if (!(group instanceof HTMLElement)) {
                return;
            }

            const hasVisibleItem = Array.from(
                group.querySelectorAll('[data-combobox-item]'),
            ).some((item) => item instanceof HTMLElement && !item.hidden);

            group.hidden = !hasVisibleItem;
        });

        content.querySelectorAll('[data-combobox-separator]').forEach((sep) => {
            if (!(sep instanceof HTMLElement)) {
                return;
            }

            sep.hidden = visibleCount === 0;
        });

        if (emptyEl instanceof HTMLElement) {
            emptyEl.hidden = visibleCount > 0;
        }
    }

    function clearHighlights() {
        options().forEach((el) => {
            el.removeAttribute('data-highlighted');
        });
        input.removeAttribute('aria-activedescendant');
    }

    function highlightActive() {
        clearHighlights();
        const list = visibleEnabledOptions();
        const el = list[activeIndex];
        if (el) {
            el.setAttribute('data-highlighted', 'true');
            el.scrollIntoView({ block: 'nearest' });
            const id = el.id;
            if (id) {
                input.setAttribute('aria-activedescendant', id);
            }
        }
    }

    /**
     * @param {boolean} next
     * @param {{ keepFilter?: boolean }} [options]
     */
    function setOpen(next, options = {}) {
        open = next;
        root.dataset.state = next ? 'open' : 'closed';
        input.setAttribute('aria-expanded', next ? 'true' : 'false');
        if (toggle instanceof HTMLButtonElement) {
            toggle.setAttribute('aria-expanded', next ? 'true' : 'false');
        }
        if (chevron instanceof HTMLElement) {
            chevron.classList.toggle('rotate-180', next);
        }
        content.hidden = !next;

        if (next) {
            if (!options.keepFilter) {
                applyFilter(input.value);
            }
            positionContent();
            const list = visibleEnabledOptions();
            const selected = hiddenInput.value;
            let index = 0;
            if (selected !== '') {
                const found = list.findIndex(
                    (el) => el.getAttribute('data-value') === selected,
                );
                index = found >= 0 ? found : 0;
            }
            activeIndex = list.length > 0 ? index : -1;
            highlightActive();
        } else {
            clearHighlights();
            activeIndex = -1;
            applyFilter('');
            options().forEach((el) => {
                el.hidden = false;
            });
            content.querySelectorAll('[data-combobox-group], [data-combobox-separator]').forEach(
                (node) => {
                    if (node instanceof HTMLElement) {
                        node.hidden = false;
                    }
                },
            );
            if (emptyEl instanceof HTMLElement) {
                emptyEl.hidden = true;
            }
        }
    }

    /**
     * @param {HTMLElement} el
     */
    function selectOption(el) {
        if (el.hasAttribute('data-disabled')) {
            return;
        }

        const value = el.getAttribute('data-value') ?? '';
        const label = optionLabel(el);

        hiddenInput.value = value;
        input.value = label;
        committedLabel = label;
        syncOptionSelection(value);
        dispatchValueEvents(hiddenInput);
        dispatchValueEvents(input);
        setOpen(false);
        input.focus();
    }

    function syncFromValue() {
        const value = hiddenInput.value;
        if (value === '') {
            committedLabel = '';
            syncOptionSelection('');
            return;
        }

        const match = options().find(
            (el) => el.getAttribute('data-value') === value,
        );
        if (match) {
            const label = optionLabel(match);
            input.value = label;
            committedLabel = label;
            syncOptionSelection(value);
        }
    }

    /**
     * @param {EventTarget | null} target
     */
    function containsTarget(target) {
        return (
            target instanceof Node &&
            (root.contains(target) || content.contains(target))
        );
    }

    input.addEventListener('focus', () => {
        if (input.disabled) {
            return;
        }
        if (!open) {
            setOpen(true);
        }
    });

    input.addEventListener('input', () => {
        if (input.disabled) {
            return;
        }

        if (committedLabel !== '' && input.value !== committedLabel) {
            hiddenInput.value = '';
            committedLabel = '';
            syncOptionSelection('');
            dispatchValueEvents(hiddenInput);
        }

        if (!open) {
            setOpen(true, { keepFilter: true });
        }

        applyFilter(input.value);
        positionContent();

        const list = visibleEnabledOptions();
        activeIndex = list.length > 0 ? 0 : -1;
        highlightActive();
    });

    if (toggle instanceof HTMLButtonElement) {
        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (toggle.disabled || input.disabled) {
                return;
            }

            if (open) {
                setOpen(false);
                input.focus();
            } else {
                setOpen(true);
                input.focus();
            }
        });
    }

    content.addEventListener('mousedown', (event) => {
        // Prevent input blur before option click handlers run.
        event.preventDefault();
    });

    content.addEventListener('click', (event) => {
        const item =
            event.target instanceof Element
                ? event.target.closest('[data-combobox-item]')
                : null;
        if (item instanceof HTMLElement) {
            selectOption(item);
        }
    });

    document.addEventListener('pointerdown', (event) => {
        if (!open) {
            return;
        }
        if (!containsTarget(event.target)) {
            setOpen(false);
            if (hiddenInput.value !== '' && committedLabel !== '') {
                input.value = committedLabel;
            }
        }
    });

    window.addEventListener('resize', () => {
        if (open) {
            positionContent();
        }
    });

    window.addEventListener(
        'scroll',
        () => {
            if (open) {
                positionContent();
            }
        },
        true,
    );

    input.addEventListener('keydown', (event) => {
        if (input.disabled) {
            return;
        }

        const list = visibleEnabledOptions();

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                if (!open) {
                    setOpen(true);
                } else if (list.length > 0) {
                    activeIndex = Math.min(activeIndex + 1, list.length - 1);
                    if (activeIndex < 0) {
                        activeIndex = 0;
                    }
                    highlightActive();
                }
                break;
            case 'ArrowUp':
                event.preventDefault();
                if (!open) {
                    setOpen(true);
                } else if (list.length > 0) {
                    activeIndex = Math.max(activeIndex - 1, 0);
                    highlightActive();
                }
                break;
            case 'Home':
                if (open && list.length > 0) {
                    event.preventDefault();
                    activeIndex = 0;
                    highlightActive();
                }
                break;
            case 'End':
                if (open && list.length > 0) {
                    event.preventDefault();
                    activeIndex = list.length - 1;
                    highlightActive();
                }
                break;
            case 'Enter':
                if (open) {
                    event.preventDefault();
                    const el = list[activeIndex];
                    if (el) {
                        selectOption(el);
                    }
                }
                break;
            case 'Escape':
                if (open) {
                    event.preventDefault();
                    setOpen(false);
                    if (hiddenInput.value !== '' && committedLabel !== '') {
                        input.value = committedLabel;
                    }
                }
                break;
            case 'Tab':
                if (open) {
                    setOpen(false);
                    if (hiddenInput.value !== '' && committedLabel !== '') {
                        input.value = committedLabel;
                    }
                }
                break;
            default:
                break;
        }
    });

    root.dataset.state = 'closed';
    syncFromValue();
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initComboboxes(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initComboboxes());
    } else {
        initComboboxes();
    }
}
