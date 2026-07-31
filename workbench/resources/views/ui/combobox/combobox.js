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
    const isMultiple = root.hasAttribute('data-combobox-multiple');
    const displayMode = root.getAttribute('data-combobox-display') ?? 'count';
    const countTemplate = root.getAttribute('data-combobox-count-template') ?? '{count} selected';
    const chipRemoveLabel = root.getAttribute('data-combobox-chip-remove-label') ?? 'Remove';

    /** @type {HTMLInputElement | null} */
    const singleInput = root.querySelector('[data-combobox-input]');
    /** @type {HTMLInputElement | null} */
    const filterInput = root.querySelector('[data-combobox-filter-input]');
    const input = isMultiple && filterInput instanceof HTMLInputElement
        ? filterInput
        : singleInput;

    const toggle = root.querySelector('[data-combobox-toggle]');
    const content = root.querySelector('[data-combobox-content]');
    const emptyEl = root.querySelector('[data-combobox-empty]');
    /** @type {HTMLInputElement | null} */
    const singleHiddenInput = ! isMultiple
        ? root.querySelector('[data-combobox-hidden-input]')
        : null;
    const hiddenInputsContainer = root.querySelector('[data-combobox-hidden-inputs]');
    const valueEl = root.querySelector('[data-combobox-value]');
    const chipsEl = root.querySelector('[data-combobox-chips]');
    /** @type {HTMLTemplateElement | null} */
    const chipTemplate = root.querySelector('template[data-combobox-chip-template]');
    const chevron = root.querySelector('[data-combobox-chevron]');

    if (!(input instanceof HTMLInputElement) || !(content instanceof HTMLElement)) {
        return;
    }

    if (! isMultiple && !(singleHiddenInput instanceof HTMLInputElement)) {
        return;
    }

    if (isMultiple && !(hiddenInputsContainer instanceof HTMLElement)) {
        return;
    }

    const placeholderFromValueEl = valueEl instanceof HTMLElement
        ? valueEl.getAttribute('data-placeholder') ?? ''
        : '';
    const placeholderFromChips = chipsEl instanceof HTMLElement
        ? chipsEl.getAttribute('data-placeholder') ?? ''
        : '';

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
     * @returns {string[]}
     */
    function getSelectedValues() {
        if (! isMultiple) {
            return singleHiddenInput instanceof HTMLInputElement && singleHiddenInput.value !== ''
                ? [singleHiddenInput.value]
                : [];
        }

        return Array.from(
            hiddenInputsContainer.querySelectorAll('[data-combobox-hidden-input]'),
        )
            .filter((node) => node instanceof HTMLInputElement)
            .map((node) => node.value)
            .filter((value) => value !== '');
    }

    /**
     * @param {string[]} values
     */
    function setSelectedValues(values) {
        const unique = [...new Set(values)];

        if (! isMultiple && singleHiddenInput instanceof HTMLInputElement) {
            singleHiddenInput.value = unique[0] ?? '';
            syncOptionSelection(unique[0] ?? '');
            renderTrigger();
            dispatchValueEvents(singleHiddenInput);

            return;
        }

        const fieldName = hiddenInputsContainer.getAttribute('data-combobox-field-name') ?? '';

        hiddenInputsContainer
            .querySelectorAll('[data-combobox-hidden-input]')
            .forEach((node) => node.remove());

        unique.forEach((value) => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.value = value;
            hidden.setAttribute('data-combobox-hidden-input', '');

            if (fieldName !== '') {
                hidden.name = fieldName;
            }

            hiddenInputsContainer.appendChild(hidden);
        });

        syncOptionSelectionMulti(unique);
        renderTrigger();

        hiddenInputsContainer
            .querySelectorAll('[data-combobox-hidden-input]')
            .forEach((node) => {
                if (node instanceof HTMLInputElement) {
                    dispatchValueEvents(node);
                }
            });
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

    /**
     * @param {string[]} values
     */
    function syncOptionSelectionMulti(values) {
        const set = new Set(values);

        options().forEach((item) => {
            const itemValue = item.getAttribute('data-value') ?? '';
            item.setAttribute('aria-selected', set.has(itemValue) ? 'true' : 'false');
        });
    }

    /**
     * @param {string} value
     * @param {string} label
     */
    function createChipElement(value, label) {
        if (!(chipTemplate instanceof HTMLTemplateElement)) {
            return null;
        }

        const fragment = chipTemplate.content.cloneNode(true);
        const chip = fragment.querySelector('[data-combobox-chip]');

        if (!(chip instanceof HTMLElement)) {
            return null;
        }

        chip.setAttribute('data-value', value);

        const labelEl = chip.querySelector('[data-combobox-chip-label]');

        if (labelEl instanceof HTMLElement) {
            labelEl.textContent = label;
        }

        const remove = chip.querySelector('[data-combobox-chip-remove]');

        if (remove instanceof HTMLButtonElement) {
            remove.setAttribute('aria-label', `${chipRemoveLabel} ${label}`);
        }

        return chip;
    }

    function renderTrigger() {
        if (! isMultiple) {
            return;
        }

        const selected = getSelectedValues();

        if (displayMode === 'count' && valueEl instanceof HTMLElement) {
            if (selected.length === 0) {
                const placeholder = placeholderFromValueEl || placeholderFromChips;

                if (placeholder !== '') {
                    valueEl.textContent = placeholder;
                    valueEl.setAttribute('data-placeholder', 'true');
                } else {
                    valueEl.textContent = '';
                    valueEl.removeAttribute('data-placeholder');
                }

                return;
            }

            valueEl.textContent = countTemplate.replace('{count}', String(selected.length));
            valueEl.removeAttribute('data-placeholder');

            return;
        }

        if (displayMode === 'chips' && chipsEl instanceof HTMLElement) {
            chipsEl
                .querySelectorAll('[data-combobox-chip]')
                .forEach((chip) => chip.remove());

            if (selected.length === 0 && placeholderFromChips !== '') {
                const empty = document.createElement('span');
                empty.className = 'text-sm text-zinc-500 dark:text-zinc-400';
                empty.setAttribute('data-combobox-chips-placeholder', 'true');
                empty.textContent = placeholderFromChips;
                chipsEl.appendChild(empty);

                return;
            }

            chipsEl
                .querySelectorAll('[data-combobox-chips-placeholder]')
                .forEach((node) => node.remove());

            selected.forEach((value) => {
                const match = options().find((el) => el.getAttribute('data-value') === value);
                const label = match ? optionLabel(match) : value;
                const chip = createChipElement(value, label);

                if (chip) {
                    chipsEl.appendChild(chip);
                }
            });
        }
    }

    /**
     * @param {string} value
     */
    function removeValue(value) {
        setSelectedValues(getSelectedValues().filter((item) => item !== value));
    }

    function ensurePortal() {
        if (content.parentElement === document.body) {
            return;
        }

        const parent = content.parentElement;

        if (parent && ! portalInserted) {
            parent.insertBefore(portalMarker, content);
            portalInserted = true;
        }

        document.body.appendChild(content);
        content.dataset.comboboxPortaled = 'true';
    }

    function positionContent() {
        ensurePortal();

        const wrap = root.querySelector('[data-combobox-input-wrap]');
        const anchor = wrap instanceof HTMLElement ? wrap : input;

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
            const match = q === '' || optionLabel(el).toLowerCase().includes(q);
            el.hidden = ! match;

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
            ).some((item) => item instanceof HTMLElement && ! item.hidden);

            group.hidden = ! hasVisibleItem;
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
     * @param {{ keepFilter?: boolean }} [opts]
     */
    function setOpen(next, opts = {}) {
        open = next;
        root.dataset.state = next ? 'open' : 'closed';
        input.setAttribute('aria-expanded', next ? 'true' : 'false');

        if (toggle instanceof HTMLButtonElement) {
            toggle.setAttribute('aria-expanded', next ? 'true' : 'false');
        }

        if (chevron instanceof HTMLElement) {
            chevron.classList.toggle('rotate-180', next);
        }

        content.hidden = ! next;

        if (next) {
            if (! opts.keepFilter) {
                applyFilter(input.value);
            }

            positionContent();
            const list = visibleEnabledOptions();
            const selected = getSelectedValues();
            let index = 0;

            if (! isMultiple && selected.length > 0) {
                const found = list.findIndex(
                    (el) => el.getAttribute('data-value') === selected[0],
                );
                index = found >= 0 ? found : 0;
            } else if (isMultiple && selected.length > 0) {
                const found = list.findIndex((el) =>
                    selected.includes(el.getAttribute('data-value') ?? ''),
                );
                index = found >= 0 ? found : 0;
            }

            activeIndex = list.length > 0 ? index : -1;
            highlightActive();
        } else {
            clearHighlights();
            activeIndex = -1;
            applyFilter('');

            if (isMultiple) {
                input.value = '';
            }

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

        if (isMultiple) {
            const current = getSelectedValues();
            const next = current.includes(value)
                ? current.filter((item) => item !== value)
                : [...current, value];

            setSelectedValues(next);
            input.value = '';
            applyFilter('');
            positionContent();
            input.focus();

            return;
        }

        if (!(singleHiddenInput instanceof HTMLInputElement)) {
            return;
        }

        singleHiddenInput.value = value;
        input.value = label;
        committedLabel = label;
        syncOptionSelection(value);
        dispatchValueEvents(singleHiddenInput);
        dispatchValueEvents(input);
        setOpen(false);
        input.focus();
    }

    function syncFromValue() {
        if (isMultiple) {
            syncOptionSelectionMulti(getSelectedValues());
            renderTrigger();

            return;
        }

        if (!(singleHiddenInput instanceof HTMLInputElement)) {
            return;
        }

        const value = singleHiddenInput.value;

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
            target instanceof Node
            && (root.contains(target) || content.contains(target))
        );
    }

    if (chipsEl instanceof HTMLElement) {
        chipsEl.addEventListener('click', (event) => {
            const remove = event.target instanceof Element
                ? event.target.closest('[data-combobox-chip-remove]')
                : null;

            if (remove instanceof HTMLElement) {
                event.preventDefault();
                const chip = remove.closest('[data-combobox-chip]');

                if (chip instanceof HTMLElement) {
                    const value = chip.getAttribute('data-value') ?? '';
                    removeValue(value);
                }
            }
        });
    }

    input.addEventListener('focus', () => {
        if (input.disabled) {
            return;
        }

        if (! open) {
            setOpen(true);
        }
    });

    input.addEventListener('input', () => {
        if (input.disabled) {
            return;
        }

        if (! isMultiple && singleHiddenInput instanceof HTMLInputElement) {
            if (committedLabel !== '' && input.value !== committedLabel) {
                singleHiddenInput.value = '';
                committedLabel = '';
                syncOptionSelection('');
                dispatchValueEvents(singleHiddenInput);
            }
        }

        if (! open) {
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
        event.preventDefault();
    });

    content.addEventListener('click', (event) => {
        const item = event.target instanceof Element
            ? event.target.closest('[data-combobox-item]')
            : null;

        if (item instanceof HTMLElement) {
            selectOption(item);
        }
    });

    document.addEventListener('pointerdown', (event) => {
        if (! open) {
            return;
        }

        if (! containsTarget(event.target)) {
            setOpen(false);

            if (! isMultiple && singleHiddenInput instanceof HTMLInputElement) {
                if (singleHiddenInput.value !== '' && committedLabel !== '') {
                    input.value = committedLabel;
                }
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

                if (! open) {
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

                if (! open) {
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

                    if (! isMultiple && singleHiddenInput instanceof HTMLInputElement) {
                        if (singleHiddenInput.value !== '' && committedLabel !== '') {
                            input.value = committedLabel;
                        }
                    }
                }

                break;
            case 'Tab':
                if (open) {
                    setOpen(false);

                    if (! isMultiple && singleHiddenInput instanceof HTMLInputElement) {
                        if (singleHiddenInput.value !== '' && committedLabel !== '') {
                            input.value = committedLabel;
                        }
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
