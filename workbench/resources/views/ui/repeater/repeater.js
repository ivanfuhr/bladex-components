/**
 * Stencil — dynamic form repeater for Laravel array fields (vanilla JS, no Alpine).
 */

const REPEATER_SELECTOR = '[data-repeater]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initRepeaters(root = document) {
    root.querySelectorAll(REPEATER_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindRepeater(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindRepeater(root) {
    const list = root.querySelector('[data-repeater-list]');
    /** @type {HTMLTemplateElement | null} */
    const template = root.querySelector('template[data-repeater-item-template]');
    const fieldName = root.getAttribute('data-repeater-name') ?? '';
    const min = Number.parseInt(root.getAttribute('data-repeater-min') ?? '0', 10);
    const maxAttr = root.getAttribute('data-repeater-max');
    const max = maxAttr !== null && maxAttr !== '' ? Number.parseInt(maxAttr, 10) : null;
    const disabled = root.hasAttribute('data-disabled');
    const sortable = root.hasAttribute('data-repeater-sortable');

    /** @type {Array<Record<string, unknown>>} */
    let seedValue = [];

    try {
        const parsed = JSON.parse(root.getAttribute('data-repeater-value') ?? '[]');

        if (Array.isArray(parsed)) {
            seedValue = parsed;
        }
    } catch {
        seedValue = [];
    }

    if (
        !(list instanceof HTMLElement) ||
        !(template instanceof HTMLTemplateElement) ||
        fieldName === ''
    ) {
        return;
    }

    /**
     * @param {HTMLElement} item
     */
    function dispatchMount(item) {
        item.dispatchEvent(
            new CustomEvent('stencil:mount', {
                bubbles: true,
                detail: { root: item },
            }),
        );
    }

    /**
     * @param {HTMLElement} target
     */
    function dispatchChange(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @param {HTMLElement} fieldRoot
     * @returns {Array<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>}
     */
    function resolveControls(fieldRoot) {
        if (
            fieldRoot instanceof HTMLInputElement ||
            fieldRoot instanceof HTMLTextAreaElement ||
            fieldRoot instanceof HTMLSelectElement
        ) {
            return [fieldRoot];
        }

        const controls = Array.from(fieldRoot.querySelectorAll('input, textarea, select')).filter(
            (control) => {
                if (!(control instanceof HTMLElement)) {
                    return false;
                }

                if (
                    control.closest('[data-repeater-item]') !==
                    fieldRoot.closest('[data-repeater-item]')
                ) {
                    return false;
                }

                return true;
            },
        );

        return controls.filter(
            (control) =>
                control instanceof HTMLInputElement ||
                control instanceof HTMLTextAreaElement ||
                control instanceof HTMLSelectElement,
        );
    }

    /**
     * @param {HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement} control
     * @returns {unknown}
     */
    function readControlValue(control) {
        if (control instanceof HTMLInputElement) {
            const type = (control.type || 'text').toLowerCase();

            if (type === 'checkbox') {
                return control.checked;
            }

            if (type === 'radio') {
                return control.checked ? control.value : undefined;
            }

            return control.value;
        }

        return control.value;
    }

    /**
     * @param {HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement} control
     * @param {unknown} fieldValue
     */
    function fillControlValue(control, fieldValue) {
        if (control instanceof HTMLInputElement) {
            const type = (control.type || 'text').toLowerCase();

            if (type === 'checkbox') {
                if (Array.isArray(fieldValue)) {
                    control.checked = fieldValue.map(String).includes(control.value);
                } else {
                    control.checked = Boolean(fieldValue);
                }

                return;
            }

            if (type === 'radio') {
                control.checked = String(control.value) === String(fieldValue);

                return;
            }

            control.value =
                fieldValue === null || fieldValue === undefined ? '' : String(fieldValue);

            return;
        }

        control.value = fieldValue === null || fieldValue === undefined ? '' : String(fieldValue);
    }

    /**
     * @param {HTMLElement} item
     * @returns {Record<string, unknown>}
     */
    function readRowData(item) {
        /** @type {Record<string, unknown>} */
        const row = {};

        item.querySelectorAll('[data-repeater-field]').forEach((fieldRoot) => {
            if (!(fieldRoot instanceof HTMLElement)) {
                return;
            }

            const fieldKey = fieldRoot.getAttribute('data-repeater-field');

            if (!fieldKey) {
                return;
            }

            const controls = resolveControls(fieldRoot);

            if (controls.length === 0) {
                return;
            }

            if (controls.length === 1) {
                const value = readControlValue(controls[0]);

                if (value !== undefined) {
                    row[fieldKey] = value;
                }

                return;
            }

            const radio = controls.find(
                (control) =>
                    control instanceof HTMLInputElement &&
                    control.type === 'radio' &&
                    control.checked,
            );

            if (radio) {
                row[fieldKey] = radio.value;

                return;
            }

            const checkboxValues = controls
                .filter(
                    (control) =>
                        control instanceof HTMLInputElement &&
                        control.type === 'checkbox' &&
                        control.checked,
                )
                .map((control) => control.value);

            if (checkboxValues.length > 0) {
                row[fieldKey] = checkboxValues;
            }
        });

        return row;
    }

    /**
     * @param {HTMLElement} item
     * @param {Record<string, unknown>} rowData
     * @param {number} index
     */
    function applyRowData(item, rowData, index) {
        item.dataset.repeaterIndex = String(index);

        item.querySelectorAll('[data-repeater-field]').forEach((fieldRoot) => {
            if (!(fieldRoot instanceof HTMLElement)) {
                return;
            }

            const fieldKey = fieldRoot.getAttribute('data-repeater-field');

            if (!fieldKey) {
                return;
            }

            const controls = resolveControls(fieldRoot);
            const fieldValue = rowData[fieldKey];

            controls.forEach((control) => {
                control.name = `${fieldName}[${index}][${fieldKey}]`;

                if (fieldValue !== undefined) {
                    fillControlValue(control, fieldValue);
                }
            });
        });

        dispatchMount(item);
    }

    /**
     * @returns {Array<HTMLElement>}
     */
    function items() {
        return Array.from(list.querySelectorAll('[data-repeater-item]')).filter(
            (element) => element instanceof HTMLElement,
        );
    }

    function reindex() {
        items().forEach((item, index) => {
            applyRowData(item, readRowData(item), index);
        });

        updateControls();
    }

    /**
     * @param {Record<string, unknown>} [rowData]
     * @returns {HTMLElement | null}
     */
    function createRow(rowData = {}) {
        const fragment = template.content.cloneNode(true);
        const item =
            fragment instanceof DocumentFragment
                ? fragment.querySelector('[data-repeater-item]')
                : null;

        if (!(item instanceof HTMLElement)) {
            return null;
        }

        list.appendChild(fragment);

        const appended = list.lastElementChild;

        if (!(appended instanceof HTMLElement)) {
            return null;
        }

        applyRowData(appended, rowData, items().length - 1);

        return appended;
    }

    /**
     * @param {Record<string, unknown>} [rowData]
     */
    function addRow(rowData = {}) {
        if (disabled) {
            return;
        }

        if (max !== null && items().length >= max) {
            return;
        }

        const item = createRow(rowData);

        reindex();

        const focusable = item?.querySelector('input, textarea, select, button');

        if (focusable instanceof HTMLElement) {
            focusable.focus();
        }

        dispatchChange(root);
    }

    /**
     * @param {HTMLElement} item
     */
    function removeRow(item) {
        if (disabled) {
            return;
        }

        if (items().length <= min) {
            return;
        }

        item.remove();
        reindex();
        dispatchChange(root);
    }

    function updateControls() {
        const count = items().length;
        const addButton = root.querySelector('[data-repeater-add]');

        if (addButton instanceof HTMLButtonElement) {
            addButton.disabled = disabled || (max !== null && count >= max);
        }

        root.querySelectorAll('[data-repeater-remove]').forEach((button) => {
            if (button instanceof HTMLButtonElement) {
                button.disabled = disabled || count <= min;
            }
        });

        root.querySelectorAll('[data-repeater-duplicate]').forEach((button) => {
            if (button instanceof HTMLButtonElement) {
                button.disabled = disabled || (max !== null && count >= max);
            }
        });
    }

    function hydrate() {
        list.replaceChildren();

        const rows =
            seedValue.length > 0
                ? seedValue
                : min > 0
                  ? Array.from({ length: min }, () => ({}))
                  : [];

        rows.forEach((row) => {
            createRow(row && typeof row === 'object' ? row : {});
        });

        reindex();
        updateControls();
    }

    root.addEventListener('click', (event) => {
        if (disabled) {
            return;
        }

        const target = event.target instanceof Element ? event.target : null;

        if (!target) {
            return;
        }

        const addButton = target.closest('[data-repeater-add]');

        if (addButton && root.contains(addButton)) {
            event.preventDefault();
            addRow();

            return;
        }

        const removeButton = target.closest('[data-repeater-remove]');

        if (removeButton && root.contains(removeButton)) {
            event.preventDefault();

            const item = removeButton.closest('[data-repeater-item]');

            if (item instanceof HTMLElement) {
                removeRow(item);
            }

            return;
        }

        const duplicateButton = target.closest('[data-repeater-duplicate]');

        if (duplicateButton && root.contains(duplicateButton)) {
            event.preventDefault();

            const item = duplicateButton.closest('[data-repeater-item]');

            if (item instanceof HTMLElement) {
                addRow(readRowData(item));
            }
        }
    });

    if (sortable) {
        let draggedItem = null;

        list.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

        list.addEventListener('drop', (event) => {
            event.preventDefault();

            if (!(draggedItem instanceof HTMLElement)) {
                return;
            }

            const target =
                event.target instanceof Element
                    ? event.target.closest('[data-repeater-item]')
                    : null;

            if (!(target instanceof HTMLElement) || target === draggedItem) {
                return;
            }

            const itemsBefore = items();
            const fromIndex = itemsBefore.indexOf(draggedItem);
            const toIndex = itemsBefore.indexOf(target);

            if (fromIndex < 0 || toIndex < 0) {
                return;
            }

            if (fromIndex < toIndex) {
                target.after(draggedItem);
            } else {
                target.before(draggedItem);
            }

            reindex();
            dispatchChange(root);
            draggedItem = null;
        });

        root.querySelectorAll('[data-repeater-handle]').forEach((handle) => {
            if (!(handle instanceof HTMLElement)) {
                return;
            }

            const item = handle.closest('[data-repeater-item]');

            if (!(item instanceof HTMLElement)) {
                return;
            }

            item.setAttribute('draggable', 'true');

            handle.addEventListener('mousedown', () => {
                item.setAttribute('draggable', 'true');
            });

            item.addEventListener('dragstart', (event) => {
                if (disabled) {
                    event.preventDefault();

                    return;
                }

                draggedItem = item;
                item.classList.add('opacity-60');

                if (event.dataTransfer) {
                    event.dataTransfer.effectAllowed = 'move';
                }
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('opacity-60');
                draggedItem = null;
            });
        });
    }

    hydrate();
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initRepeaters(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initRepeaters());
    } else {
        initRepeaters();
    }
}
