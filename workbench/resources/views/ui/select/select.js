/**
 * Stencil — custom listbox select (vanilla JS, no Alpine).
 */

const SELECT_SELECTOR = '[data-select]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initSelects(root = document) {
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
    const trigger = root.querySelector('[data-select-trigger]');
    const content = root.querySelector('[data-select-content]');
    const hiddenInput = root.querySelector('[data-select-hidden-input]');
    const valueEl = root.querySelector('[data-select-value]');

    if (
        !(trigger instanceof HTMLButtonElement) ||
        !(content instanceof HTMLElement) ||
        !(hiddenInput instanceof HTMLInputElement) ||
        !(valueEl instanceof HTMLElement)
    ) {
        return;
    }

    const portalMarker = document.createComment('stencil-select-portal');
    let portalInserted = false;

    const options = () =>
        Array.from(content.querySelectorAll('[data-select-item]')).filter(
            (node) => node instanceof HTMLElement,
        );

    const enabledOptions = () =>
        options().filter((el) => !el.hasAttribute('data-disabled'));

    let open = false;
    let activeIndex = -1;
    let typeahead = '';
    let typeaheadTimer = /** @type {ReturnType<typeof setTimeout> | null} */ (null);

    const placeholder = valueEl.getAttribute('data-placeholder') === 'true'
        ? valueEl.textContent?.trim() ?? ''
        : '';

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
            positionContent();
            const current = enabledOptions().findIndex(
                (el) => el.getAttribute('data-value') === hiddenInput.value,
            );
            activeIndex = current >= 0 ? current : 0;
            highlightActive();
            content.focus();
        } else {
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

    function optionLabel(el) {
        const label = el.querySelector('[data-select-item-label]');
        if (label instanceof HTMLElement) {
            return label.textContent?.trim() ?? '';
        }

        return el.textContent?.trim() ?? '';
    }

    function selectOption(el) {
        if (el.hasAttribute('data-disabled')) {
            return;
        }

        const value = el.getAttribute('data-value') ?? '';
        const label = optionLabel(el);

        hiddenInput.value = value;
        valueEl.textContent = label;
        valueEl.removeAttribute('data-placeholder');

        options().forEach((item) => {
            const selected = item === el;
            item.setAttribute('aria-selected', selected ? 'true' : 'false');
        });

        hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));

        setOpen(false);
    }

    function syncFromValue() {
        const value = hiddenInput.value;
        if (value === '') {
            if (placeholder !== '') {
                valueEl.textContent = placeholder;
                valueEl.setAttribute('data-placeholder', 'true');
            }
            options().forEach((item) => item.setAttribute('aria-selected', 'false'));

            return;
        }

        const match = options().find((el) => el.getAttribute('data-value') === value);
        if (match) {
            valueEl.textContent = optionLabel(match);
            valueEl.removeAttribute('data-placeholder');
            options().forEach((item) => {
                item.setAttribute(
                    'aria-selected',
                    item.getAttribute('data-value') === value ? 'true' : 'false',
                );
            });
        }
    }

    function containsTarget(target) {
        return (
            target instanceof Node &&
            (root.contains(target) || content.contains(target))
        );
    }

    trigger.addEventListener('click', () => {
        if (trigger.disabled) {
            return;
        }
        setOpen(!open);
    });

    content.addEventListener('click', (event) => {
        const item = event.target instanceof Element
            ? event.target.closest('[data-select-item]')
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
                        selectOption(el);
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
                        selectOption(el);
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

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initSelects());
    } else {
        initSelects();
    }
}
