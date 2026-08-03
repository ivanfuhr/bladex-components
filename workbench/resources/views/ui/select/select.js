/**
 * Stencil — custom listbox select (vanilla JS, no Alpine).
 */

import { createBindSignal } from '../../../js/ui/lifecycle.js';
import { acquireBodyScrollLock } from '../../../js/ui/scroll-lock.js';

const SELECT_SELECTOR = '[data-select]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initSelects(root = document) {
    document
        .querySelectorAll('[data-select-content][data-select-portaled]')
        .forEach((content) => {
            if (!(content instanceof HTMLElement) || content.closest('[data-select]')) {
                return;
            }

            content.remove();
        });

    root.querySelectorAll(SELECT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindSelect(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindSelect(root) {
    const isMultiple = root.hasAttribute('data-select-multiple');
    const displayMode = root.getAttribute('data-select-display') || 'count';

    const trigger = root.querySelector('[data-select-trigger]');
    const content = root.querySelector('[data-select-content]');
    const valueEl = root.querySelector('[data-select-value]');
    const chipsEl = root.querySelector('[data-select-chips]');
    const chipTemplate = root.querySelector('template[data-select-chip-template]');

    const hiddenInputsContainer = root.querySelector('[data-select-hidden-inputs]');
    /** @type {HTMLInputElement | null} */
    const singleHiddenInput = isMultiple ? null : root.querySelector('[data-select-hidden-input]');

    if (!(trigger instanceof HTMLButtonElement) || !(content instanceof HTMLElement)) {
        return;
    }

    if (isMultiple) {
        if (!(hiddenInputsContainer instanceof HTMLElement)) {
            return;
        }
        if (displayMode === 'chips' && !(chipsEl instanceof HTMLElement)) {
            return;
        }
        if (displayMode === 'count' && !(valueEl instanceof HTMLElement)) {
            return;
        }
    } else {
        if (!(singleHiddenInput instanceof HTMLInputElement) || !(valueEl instanceof HTMLElement)) {
            return;
        }
    }

    const portalMarker = document.createComment('stencil-select-portal');
    let portalInserted = false;
    const signal = createBindSignal(root);

    const options = () =>
        Array.from(content.querySelectorAll('[data-select-item]')).filter(
            (node) => node instanceof HTMLElement,
        );

    const enabledOptions = () => options().filter((el) => !el.hasAttribute('data-disabled'));

    let open = false;
    let activeIndex = -1;
    let typeahead = '';
    let typeaheadTimer = /** @type {ReturnType<typeof setTimeout> | null} */ (null);
    /** @type {(() => void) | null} */
    let releaseScrollLock = null;

    const countTemplate = root.getAttribute('data-select-count-template') ?? '{count} selected';
    const chipRemoveLabel = root.getAttribute('data-select-chip-remove-label') ?? 'Remove';

    const placeholderFromValueEl =
        valueEl instanceof HTMLElement && valueEl.getAttribute('data-placeholder') === 'true'
            ? (valueEl.textContent?.trim() ?? '')
            : '';

    const placeholderFromChips =
        chipsEl instanceof HTMLElement
            ? (chipsEl.getAttribute('data-placeholder') ?? '').trim()
            : '';

    /**
     * @returns {string[]}
     */
    function getSelectedValues() {
        if (!isMultiple) {
            return singleHiddenInput instanceof HTMLInputElement && singleHiddenInput.value !== ''
                ? [singleHiddenInput.value]
                : [];
        }

        if (!(hiddenInputsContainer instanceof HTMLElement)) {
            return [];
        }

        return Array.from(hiddenInputsContainer.querySelectorAll('[data-select-hidden-input]'))
            .filter((node) => node instanceof HTMLInputElement)
            .map((input) => input.value)
            .filter((value) => value !== '');
    }

    /**
     * @param {string[]} values
     */
    function setSelectedValues(values) {
        const unique = [...new Set(values)];

        if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
            singleHiddenInput.value = unique[0] ?? '';
            syncOptionSelection(unique[0] ?? '');
            renderTrigger();
            dispatchValueEvents(singleHiddenInput);

            return;
        }

        if (!(hiddenInputsContainer instanceof HTMLElement)) {
            return;
        }

        const fieldName = hiddenInputsContainer.getAttribute('data-select-field-name') ?? '';

        hiddenInputsContainer
            .querySelectorAll('[data-select-hidden-input]')
            .forEach((node) => node.remove());

        unique.forEach((value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.value = value;
            input.setAttribute('data-select-hidden-input', '');
            if (fieldName !== '') {
                input.name = fieldName;
            }
            hiddenInputsContainer.appendChild(input);
        });

        syncOptionSelectionMulti(unique);
        renderTrigger();

        const inputs = hiddenInputsContainer.querySelectorAll('[data-select-hidden-input]');
        inputs.forEach((input) => {
            if (input instanceof HTMLInputElement) {
                dispatchValueEvents(input);
            }
        });
    }

    /**
     * @param {HTMLInputElement} input
     */
    function dispatchValueEvents(input) {
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
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
        content.dataset.selectPortaled = 'true';
    }

    function positionContent() {
        ensurePortal();

        const rect = trigger.getBoundingClientRect();
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

    function setOpen(next) {
        open = next;
        root.dataset.state = next ? 'open' : 'closed';
        trigger.setAttribute('aria-expanded', next ? 'true' : 'false');
        content.hidden = !next;

        if (next) {
            releaseScrollLock?.();
            releaseScrollLock = acquireBodyScrollLock(content, { signal });
            positionContent();
            const list = enabledOptions();
            const selected = getSelectedValues();
            let index = 0;
            if (selected.length > 0) {
                const found = list.findIndex((el) =>
                    selected.includes(el.getAttribute('data-value') ?? ''),
                );
                index = found >= 0 ? found : 0;
            }
            activeIndex = index;
            highlightActive();
            content.focus();
        } else {
            releaseScrollLock?.();
            releaseScrollLock = null;
            clearHighlights();
            activeIndex = -1;
            trigger.focus();
        }
    }

    function clearHighlights() {
        options().forEach((el) => {
            el.removeAttribute('data-highlighted');
        });
    }

    function highlightActive() {
        clearHighlights();
        const list = enabledOptions();
        const el = list[activeIndex];
        if (el) {
            el.setAttribute('data-highlighted', 'true');
            el.scrollIntoView({ block: 'nearest' });
        }
    }

    /**
     * @param {HTMLElement} el
     */
    function optionLabel(el) {
        const label = el.querySelector('[data-select-item-label]');
        if (label instanceof HTMLElement) {
            return label.textContent?.trim() ?? '';
        }

        return el.textContent?.trim() ?? '';
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

        if (singleHiddenInput instanceof HTMLInputElement && valueEl instanceof HTMLElement) {
            singleHiddenInput.value = value;
            valueEl.textContent = label;
            valueEl.removeAttribute('data-placeholder');
            syncOptionSelection(value);
            dispatchValueEvents(singleHiddenInput);
            setOpen(false);
        }
    }

    /**
     * @param {HTMLElement} el
     */
    function toggleOption(el) {
        if (el.hasAttribute('data-disabled')) {
            return;
        }

        const value = el.getAttribute('data-value') ?? '';
        const current = getSelectedValues();
        const next = current.includes(value)
            ? current.filter((item) => item !== value)
            : [...current, value];

        setSelectedValues(next);
    }

    /**
     * @param {string} value
     */
    function removeValue(value) {
        setSelectedValues(getSelectedValues().filter((item) => item !== value));
    }

    function renderTrigger() {
        const selected = getSelectedValues();

        if (!isMultiple) {
            return;
        }

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
            chipsEl.querySelectorAll('[data-select-chip]').forEach((chip) => chip.remove());

            if (selected.length === 0 && placeholderFromChips !== '') {
                const empty = document.createElement('span');
                empty.className = 'text-sm text-zinc-500 dark:text-zinc-400';
                empty.setAttribute('data-select-chips-placeholder', 'true');
                empty.textContent = placeholderFromChips;
                chipsEl.appendChild(empty);

                return;
            }

            chipsEl
                .querySelectorAll('[data-select-chips-placeholder]')
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
     * @param {string} label
     */
    function createChipElement(value, label) {
        if (!(chipTemplate instanceof HTMLTemplateElement)) {
            return null;
        }

        const fragment = chipTemplate.content.cloneNode(true);
        const chip = fragment.querySelector('[data-select-chip]');
        if (!(chip instanceof HTMLElement)) {
            return null;
        }

        chip.setAttribute('data-value', value);

        const labelEl = chip.querySelector('[data-select-chip-label]');
        if (labelEl instanceof HTMLElement) {
            labelEl.textContent = label;
        }

        const remove = chip.querySelector('[data-select-chip-remove]');
        if (remove instanceof HTMLButtonElement) {
            remove.setAttribute('aria-label', `${chipRemoveLabel} ${label}`);
        }

        return chip;
    }

    function syncFromValue() {
        if (
            !isMultiple &&
            singleHiddenInput instanceof HTMLInputElement &&
            valueEl instanceof HTMLElement
        ) {
            const value = singleHiddenInput.value;
            if (value === '') {
                if (placeholderFromValueEl !== '') {
                    valueEl.textContent = placeholderFromValueEl;
                    valueEl.setAttribute('data-placeholder', 'true');
                }
                options().forEach((item) => item.setAttribute('aria-selected', 'false'));

                return;
            }

            const match = options().find((el) => el.getAttribute('data-value') === value);
            if (match) {
                valueEl.textContent = optionLabel(match);
                valueEl.removeAttribute('data-placeholder');
                syncOptionSelection(value);
            }

            return;
        }

        if (isMultiple) {
            syncOptionSelectionMulti(getSelectedValues());
            renderTrigger();
        }
    }

    /**
     * @param {EventTarget | null} target
     */
    function containsTarget(target) {
        return target instanceof Node && (root.contains(target) || content.contains(target));
    }

    /**
     * @param {HTMLElement} el
     */
    function activateOption(el) {
        if (isMultiple) {
            toggleOption(el);
        } else {
            selectOption(el);
        }
    }

    trigger.addEventListener('click', () => {
        if (trigger.disabled) {
            return;
        }
        setOpen(!open);
    });

    if (chipsEl instanceof HTMLElement) {
        chipsEl.addEventListener('click', (event) => {
            const remove =
                event.target instanceof Element
                    ? event.target.closest('[data-select-chip-remove]')
                    : null;
            if (!(remove instanceof HTMLElement)) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const chip = remove.closest('[data-select-chip]');
            if (chip instanceof HTMLElement) {
                const value = chip.getAttribute('data-value') ?? '';
                if (value !== '') {
                    removeValue(value);
                }
            }
        });
    }

    content.addEventListener('click', (event) => {
        const item =
            event.target instanceof Element ? event.target.closest('[data-select-item]') : null;
        if (item instanceof HTMLElement) {
            activateOption(item);
        }
    });

    document.addEventListener(
        'pointerdown',
        (event) => {
            if (!open) {
                return;
            }
            if (!containsTarget(event.target)) {
                setOpen(false);
            }
        },
        { signal },
    );

    window.addEventListener(
        'resize',
        () => {
            if (open) {
                positionContent();
            }
        },
        { signal },
    );

    trigger.addEventListener('keydown', (event) => {
        if (trigger.disabled) {
            return;
        }

        const list = enabledOptions();

        switch (event.key) {
            case 'ArrowDown':
            case 'ArrowUp':
            case 'Enter':
            case ' ':
                event.preventDefault();
                if (!open) {
                    setOpen(true);
                } else if (event.key === 'Enter' || event.key === ' ') {
                    const el = list[activeIndex];
                    if (el) {
                        activateOption(el);
                    }
                }
                break;
            case 'Escape':
                if (open) {
                    event.preventDefault();
                    setOpen(false);
                }
                break;
            default:
                break;
        }
    });

    content.addEventListener('keydown', (event) => {
        const list = enabledOptions();
        if (list.length === 0) {
            return;
        }

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                activeIndex = Math.min(activeIndex + 1, list.length - 1);
                highlightActive();
                break;
            case 'ArrowUp':
                event.preventDefault();
                activeIndex = Math.max(activeIndex - 1, 0);
                highlightActive();
                break;
            case 'Home':
                event.preventDefault();
                activeIndex = 0;
                highlightActive();
                break;
            case 'End':
                event.preventDefault();
                activeIndex = list.length - 1;
                highlightActive();
                break;
            case 'Enter':
            case ' ':
                event.preventDefault();
                {
                    const el = list[activeIndex];
                    if (el) {
                        activateOption(el);
                    }
                }
                break;
            case 'Escape':
                event.preventDefault();
                setOpen(false);
                break;
            case 'Tab':
                setOpen(false);
                break;
            default:
                if (event.key.length === 1 && !event.ctrlKey && !event.metaKey && !event.altKey) {
                    typeahead += event.key.toLowerCase();
                    if (typeaheadTimer) {
                        clearTimeout(typeaheadTimer);
                    }
                    typeaheadTimer = setTimeout(() => {
                        typeahead = '';
                    }, 500);

                    const index = list.findIndex((el) =>
                        optionLabel(el).toLowerCase().startsWith(typeahead),
                    );
                    if (index >= 0) {
                        activeIndex = index;
                        highlightActive();
                    }
                }
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

    initSelects(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initSelects());
    } else {
        initSelects();
    }
}
