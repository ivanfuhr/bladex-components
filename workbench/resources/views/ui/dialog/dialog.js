/**
 * Stencil — accessible modal dialogs (native <dialog>, vanilla JS).
 */

const DIALOG_CONTENT_SELECTOR = '[data-dialog-content]';
const initialized = new WeakSet();

/** @type {Map<string, HTMLDialogElement>} */
const namedDialogs = new Map();

/**
 * @param {ParentNode} root
 */
export function initDialogs(root = document) {
    root.querySelectorAll(DIALOG_CONTENT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLDialogElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindDialog(element);
    });

    root.querySelectorAll('[data-dialog-trigger], [data-dialog-open]').forEach((trigger) => {
        if (!(trigger instanceof HTMLElement)) {
            return;
        }

        if (trigger.dataset.dialogTriggerBound === 'true') {
            return;
        }

        trigger.dataset.dialogTriggerBound = 'true';
        bindTrigger(trigger);
    });
}

/**
 * @param {string} name
 */
export function showDialog(name) {
    const dialog = namedDialogs.get(name);

    if (dialog instanceof HTMLDialogElement && !dialog.open) {
        openDialog(dialog);
    }
}

/**
 * @param {string} name
 */
export function closeDialog(name) {
    const dialog = namedDialogs.get(name);

    if (dialog instanceof HTMLDialogElement && dialog.open) {
        dialog.close();
    }
}

/**
 * @param {HTMLDialogElement} dialog
 */
function openDialog(dialog) {
    const previouslyFocused =
        document.activeElement instanceof HTMLElement ? document.activeElement : null;

    dialog.dataset.dialogPreviouslyFocused = previouslyFocused ? 'stored' : '';

    if (previouslyFocused) {
        dialog._stencilPreviousFocus = previouslyFocused;
    }

    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }

    dialog.dataset.state = 'open';
    dialog.dispatchEvent(
        new CustomEvent('stencil:dialog:open', {
            bubbles: true,
            detail: { name: dialog.dataset.dialogName ?? null },
        }),
    );

    focusInitialElement(dialog);
}

/**
 * @param {HTMLDialogElement} dialog
 */
function bindDialog(dialog) {
    const name = dialog.dataset.dialogName;

    if (typeof name === 'string' && name !== '') {
        namedDialogs.set(name, dialog);
    }

    const dismissible = dialog.dataset.dialogDismissible !== 'false';

    dialog.addEventListener('cancel', (event) => {
        if (!dismissible) {
            event.preventDefault();

            return;
        }

        dialog.dispatchEvent(
            new CustomEvent('stencil:dialog:cancel', {
                bubbles: true,
                detail: { name: name ?? null },
            }),
        );
    });

    dialog.addEventListener('close', () => {
        dialog.dataset.state = 'closed';
        restoreFocus(dialog);
        dialog.dispatchEvent(
            new CustomEvent('stencil:dialog:close', {
                bubbles: true,
                detail: { name: name ?? null },
            }),
        );
    });

    dialog.addEventListener('click', (event) => {
        if (!dismissible) {
            return;
        }

        const panel = dialog.querySelector('[data-dialog-panel]');

        if (!(panel instanceof HTMLElement)) {
            return;
        }

        if (event.target === dialog) {
            dialog.close();
        }
    });

    dialog.querySelectorAll('[data-dialog-close]').forEach((control) => {
        if (!(control instanceof HTMLElement)) {
            return;
        }

        control.addEventListener('click', (event) => {
            event.preventDefault();

            if (dialog.open) {
                dialog.close();
            }
        });
    });

    dialog.dataset.state = dialog.open ? 'open' : 'closed';
}

/**
 * @param {HTMLElement} trigger
 */
function bindTrigger(trigger) {
    trigger.addEventListener('click', (event) => {
        const target =
            event.target instanceof Element
                ? event.target.closest('button, a[href], [role="button"]')
                : null;

        if (target instanceof HTMLButtonElement && target.disabled) {
            return;
        }

        if (
            target instanceof HTMLAnchorElement &&
            target.getAttribute('aria-disabled') === 'true'
        ) {
            return;
        }

        event.preventDefault();

        const dialog = resolveDialogForTrigger(trigger);

        if (dialog instanceof HTMLDialogElement) {
            openDialog(dialog);
        }
    });
}

/**
 * @param {HTMLElement} trigger
 * @returns {HTMLDialogElement | null}
 */
function resolveDialogForTrigger(trigger) {
    const explicitName = trigger.dataset.dialogName ?? trigger.dataset.dialogOpen;

    if (typeof explicitName === 'string' && explicitName !== '') {
        const named = namedDialogs.get(explicitName);

        return named instanceof HTMLDialogElement ? named : null;
    }

    const root = trigger.closest('[data-dialog]');

    if (root instanceof HTMLElement) {
        const rootName = root.dataset.dialogName;

        if (typeof rootName === 'string' && rootName !== '') {
            const named = namedDialogs.get(rootName);

            if (named instanceof HTMLDialogElement) {
                return named;
            }
        }

        const local = root.querySelector(DIALOG_CONTENT_SELECTOR);

        if (local instanceof HTMLDialogElement) {
            return local;
        }
    }

    return null;
}

/**
 * @param {HTMLDialogElement} dialog
 */
function focusInitialElement(dialog) {
    const focusTarget =
        dialog.querySelector('[data-dialog-initial-focus]') ??
        dialog.querySelector(
            'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])',
        );

    if (focusTarget instanceof HTMLElement) {
        focusTarget.focus();
    }
}

/**
 * @param {HTMLDialogElement} dialog
 */
function restoreFocus(dialog) {
    const previous = dialog._stencilPreviousFocus;

    if (previous instanceof HTMLElement && document.contains(previous)) {
        previous.focus();
    }

    delete dialog._stencilPreviousFocus;
}

function closeAllDialogs() {
    document.querySelectorAll(DIALOG_CONTENT_SELECTOR).forEach((element) => {
        if (element instanceof HTMLDialogElement && element.open) {
            element.close();
        }
    });
}

if (typeof window !== 'undefined') {
    window.Stencil = window.Stencil ?? {};
    window.Stencil.dialog = (name) => ({
        show: () => showDialog(name),
        close: () => closeDialog(name),
    });
    window.Stencil.dialogs = {
        closeAll: () => closeAllDialogs(),
    };
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initDialogs());
    } else {
        initDialogs();
    }
}
