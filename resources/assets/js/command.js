/**
 * Stencil — command palette / cmdk (vanilla JS, no Alpine).
 */

import { createBindSignal } from './shared/lifecycle.js';

const COMMAND_SELECTOR = '[data-command]';
const DIALOG_SHORTCUT_SELECTOR = '[data-command-dialog][data-command-shortcut]';
const initialized = new WeakSet();
const shortcutBound = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initCommands(root = document) {
    root.querySelectorAll(COMMAND_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindCommand(element);
    });

    bindDocumentShortcuts(root);
}

/**
 * @param {ParentNode} root
 */
function bindDocumentShortcuts(root) {
    const scope = root instanceof Document ? root : document;

    scope.querySelectorAll(DIALOG_SHORTCUT_SELECTOR).forEach((dialog) => {
        if (!(dialog instanceof HTMLDialogElement)) {
            return;
        }

        if (shortcutBound.has(dialog)) {
            return;
        }

        shortcutBound.add(dialog);
        bindDialogShortcut(dialog);
    });
}

/**
 * @param {HTMLDialogElement} dialog
 */
function bindDialogShortcut(dialog) {
    const shortcut = dialog.getAttribute('data-command-shortcut');

    if (!shortcut) {
        return;
    }

    const parsed = parseShortcut(shortcut);

    if (!parsed) {
        return;
    }

    const signal = createBindSignal(dialog);

    document.addEventListener(
        'keydown',
        (event) => {
            if (!document.contains(dialog)) {
                return;
            }

            if (!matchesShortcut(event, parsed)) {
                return;
            }

            const target = event.target;

            if (
                target instanceof HTMLElement &&
                (target.isContentEditable ||
                    ((target instanceof HTMLInputElement ||
                        target instanceof HTMLTextAreaElement ||
                        target instanceof HTMLSelectElement) &&
                        !dialog.contains(target) &&
                        !event.metaKey &&
                        !event.ctrlKey))
            ) {
                // Allow ⌘K / Ctrl+K from inputs; block bare letter shortcuts while typing.
                if (!parsed.meta && !parsed.ctrl) {
                    return;
                }
            }

            event.preventDefault();

            if (dialog.open) {
                dialog.close();

                return;
            }

            openCommandDialog(dialog);
        },
        { signal },
    );
}

/**
 * @param {string} shortcut
 * @returns {{ key: string, meta: boolean, ctrl: boolean, shift: boolean, alt: boolean } | null}
 */
function parseShortcut(shortcut) {
    const parts = shortcut
        .toLowerCase()
        .split('.')
        .map((part) => part.trim())
        .filter(Boolean);

    if (parts.length === 0) {
        return null;
    }

    const key = parts[parts.length - 1];
    const mods = new Set(parts.slice(0, -1));

    return {
        key,
        meta: mods.has('meta') || mods.has('cmd') || mods.has('command'),
        ctrl: mods.has('ctrl') || mods.has('control'),
        shift: mods.has('shift'),
        alt: mods.has('alt') || mods.has('option'),
    };
}

/**
 * @param {KeyboardEvent} event
 * @param {{ key: string, meta: boolean, ctrl: boolean, shift: boolean, alt: boolean }} parsed
 */
function matchesShortcut(event, parsed) {
    const key = event.key.toLowerCase();

    if (key !== parsed.key) {
        return false;
    }

    const metaOrCtrl = parsed.meta || parsed.ctrl;
    const eventMetaOrCtrl = event.metaKey || event.ctrlKey;

    if (metaOrCtrl && !eventMetaOrCtrl) {
        return false;
    }

    if (!metaOrCtrl && (event.metaKey || event.ctrlKey)) {
        return false;
    }

    if (parsed.shift !== event.shiftKey) {
        return false;
    }

    if (parsed.alt !== event.altKey) {
        return false;
    }

    return true;
}

/**
 * @param {HTMLDialogElement} dialog
 */
function openCommandDialog(dialog) {
    if (typeof window !== 'undefined' && window.Stencil?.dialog && dialog.dataset.dialogName) {
        window.Stencil.dialog(dialog.dataset.dialogName).show();

        return;
    }

    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }

    const input = dialog.querySelector('[data-command-input]');

    if (input instanceof HTMLInputElement) {
        requestAnimationFrame(() => {
            input.focus();
            input.select();
        });
    }
}

/**
 * @param {HTMLElement} root
 */
function bindCommand(root) {
    const input = root.querySelector('[data-command-input]');
    const list = root.querySelector('[data-command-list]');
    const emptyEl = root.querySelector('[data-command-empty]');

    if (!(input instanceof HTMLInputElement) || !(list instanceof HTMLElement)) {
        return;
    }

    let activeIndex = -1;

    const items = () =>
        Array.from(list.querySelectorAll('[data-command-item]')).filter(
            (node) => node instanceof HTMLElement,
        );

    const visibleEnabledItems = () =>
        items().filter((el) => !el.hidden && !el.hasAttribute('data-disabled'));

    /**
     * @param {HTMLElement} el
     */
    function itemLabel(el) {
        const label = el.querySelector('[data-command-item-label]');

        if (label instanceof HTMLElement) {
            return label.textContent?.trim() ?? '';
        }

        return el.textContent?.trim() ?? '';
    }

    /**
     * @param {HTMLElement} el
     */
    function itemSearchText(el) {
        const keywords = el.getAttribute('data-keywords') ?? '';
        const label = itemLabel(el);

        return `${label} ${keywords}`.trim().toLowerCase();
    }

    /**
     * @param {string} query
     */
    function applyFilter(query) {
        const q = query.trim().toLowerCase();
        let visibleCount = 0;

        items().forEach((el) => {
            const match = q === '' || itemSearchText(el).includes(q);
            el.hidden = !match;

            if (match) {
                visibleCount += 1;
            }
        });

        list.querySelectorAll('[data-command-group]').forEach((group) => {
            if (!(group instanceof HTMLElement)) {
                return;
            }

            const hasVisibleItem = Array.from(group.querySelectorAll('[data-command-item]')).some(
                (item) => item instanceof HTMLElement && !item.hidden,
            );

            group.hidden = !hasVisibleItem;
        });

        list.querySelectorAll('[data-command-separator]').forEach((sep) => {
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
        items().forEach((el) => {
            el.removeAttribute('data-highlighted');
            el.setAttribute('aria-selected', 'false');
        });
        input.removeAttribute('aria-activedescendant');
    }

    function highlightActive() {
        clearHighlights();
        const enabled = visibleEnabledItems();
        const el = enabled[activeIndex];

        if (!el) {
            return;
        }

        el.setAttribute('data-highlighted', 'true');
        el.setAttribute('aria-selected', 'true');
        el.scrollIntoView({ block: 'nearest' });

        if (el.id) {
            input.setAttribute('aria-activedescendant', el.id);
        }
    }

    /**
     * @param {HTMLElement} el
     * @param {{ fromKeyboard?: boolean }} [options]
     */
    function selectItem(el, options = {}) {
        if (el.hasAttribute('data-disabled')) {
            return;
        }

        const value = el.getAttribute('data-value') ?? '';

        root.dispatchEvent(
            new CustomEvent('stencil:command:select', {
                bubbles: true,
                detail: { value, label: itemLabel(el), element: el },
            }),
        );

        // Keyboard selection synthesizes a click so onclick / Livewire handlers run.
        if (options.fromKeyboard) {
            el.dataset.commandSelectDispatching = 'true';

            if (el instanceof HTMLButtonElement || el instanceof HTMLAnchorElement) {
                el.click();
            }

            delete el.dataset.commandSelectDispatching;
        }

        const keepOpen = el.getAttribute('data-keep-open') === 'true';

        if (!keepOpen) {
            closeNearestDialog(root);
        }
    }

    /**
     * @param {HTMLElement} from
     */
    function closeNearestDialog(from) {
        const dialog = from.closest('dialog[data-dialog-content], dialog[data-command-dialog]');

        if (dialog instanceof HTMLDialogElement && dialog.open) {
            dialog.close();
        }
    }

    function resetHighlight() {
        const enabled = visibleEnabledItems();
        activeIndex = enabled.length > 0 ? 0 : -1;
        highlightActive();
    }

    input.addEventListener('input', () => {
        applyFilter(input.value);
        resetHighlight();
    });

    list.addEventListener('mousemove', (event) => {
        const item =
            event.target instanceof Element ? event.target.closest('[data-command-item]') : null;

        if (!(item instanceof HTMLElement) || item.hasAttribute('data-disabled') || item.hidden) {
            return;
        }

        const enabled = visibleEnabledItems();
        const index = enabled.indexOf(item);

        if (index >= 0 && index !== activeIndex) {
            activeIndex = index;
            highlightActive();
        }
    });

    list.addEventListener('click', (event) => {
        const item =
            event.target instanceof Element ? event.target.closest('[data-command-item]') : null;

        if (!(item instanceof HTMLElement)) {
            return;
        }

        if (item.dataset.commandSelectDispatching === 'true') {
            return;
        }

        // Allow native navigation for links; still close the palette.
        if (!(item instanceof HTMLAnchorElement)) {
            event.preventDefault();
        }

        selectItem(item);
    });

    input.addEventListener('keydown', (event) => {
        const enabled = visibleEnabledItems();

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();

                if (enabled.length === 0) {
                    break;
                }

                activeIndex = Math.min(activeIndex + 1, enabled.length - 1);

                if (activeIndex < 0) {
                    activeIndex = 0;
                }

                highlightActive();
                break;
            case 'ArrowUp':
                event.preventDefault();

                if (enabled.length === 0) {
                    break;
                }

                activeIndex = Math.max(activeIndex - 1, 0);
                highlightActive();
                break;
            case 'Home':
                if (enabled.length > 0) {
                    event.preventDefault();
                    activeIndex = 0;
                    highlightActive();
                }

                break;
            case 'End':
                if (enabled.length > 0) {
                    event.preventDefault();
                    activeIndex = enabled.length - 1;
                    highlightActive();
                }

                break;
            case 'Enter':
                if (enabled.length > 0 && activeIndex >= 0) {
                    event.preventDefault();
                    const el = enabled[activeIndex];

                    if (el) {
                        selectItem(el, { fromKeyboard: true });
                    }
                }

                break;
            case 'Escape': {
                const dialog = root.closest(
                    'dialog[data-dialog-content], dialog[data-command-dialog]',
                );

                if (dialog instanceof HTMLDialogElement && dialog.open) {
                    event.preventDefault();
                    dialog.close();
                } else if (input.value !== '') {
                    event.preventDefault();
                    input.value = '';
                    applyFilter('');
                    resetHighlight();
                }

                break;
            }
            default:
                break;
        }
    });

    const dialog = root.closest('dialog[data-dialog-content], dialog[data-command-dialog]');

    if (dialog instanceof HTMLDialogElement) {
        dialog.addEventListener('close', () => {
            input.value = '';
            applyFilter('');
            clearHighlights();
            activeIndex = -1;
        });

        dialog.addEventListener('stencil:dialog:open', () => {
            applyFilter(input.value);
            resetHighlight();
        });
    }

    applyFilter('');
    resetHighlight();
}

if (typeof window !== 'undefined') {
    window.Stencil = window.Stencil ?? {};
    window.Stencil.command = {
        init: initCommands,
    };
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initCommands(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCommands());
    } else {
        initCommands();
    }
}
