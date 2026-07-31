/**
 * Stencil — accessible file upload with drag-and-drop (vanilla JS, no Alpine).
 */

const FILE_UPLOAD_SELECTOR = '[data-file-upload]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initFileUploads(root = document) {
    root.querySelectorAll(FILE_UPLOAD_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindFileUpload(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindFileUpload(root) {
    /** @type {HTMLInputElement | null} */
    const input = root.querySelector('[data-file-upload-input]');
    const dropzone = root.querySelector('[data-file-upload-dropzone]');
    const list = root.querySelector('[data-file-upload-list]');
    /** @type {HTMLTemplateElement | null} */
    const template = root.querySelector('template[data-file-upload-item-template]');

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    const multiple = root.hasAttribute('data-file-upload-multiple') || input.multiple;
    /** @type {File[]} */
    let files = Array.from(input.files ?? []);
    let syncing = false;

    function dispatchValueEvents(target) {
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /**
     * @param {number} bytes
     */
    function formatBytes(bytes) {
        if (! Number.isFinite(bytes) || bytes < 0) {
            return '';
        }

        const units = ['B', 'KB', 'MB', 'GB', 'TB'];
        let value = bytes;
        let index = 0;

        while (value >= 1024 && index < units.length - 1) {
            value /= 1024;
            index += 1;
        }

        const precision = index === 0 ? 0 : 1;

        return `${value.toFixed(precision)} ${units[index]}`;
    }

    /**
     * @param {File} file
     * @param {string | null} accept
     */
    function matchesAccept(file, accept) {
        if (! accept || accept.trim() === '') {
            return true;
        }

        const tokens = accept
            .split(',')
            .map((token) => token.trim().toLowerCase())
            .filter(Boolean);

        if (tokens.length === 0) {
            return true;
        }

        const fileName = file.name.toLowerCase();
        const mime = (file.type || '').toLowerCase();

        return tokens.some((token) => {
            if (token.startsWith('.')) {
                return fileName.endsWith(token);
            }

            if (token.endsWith('/*')) {
                const prefix = token.slice(0, -1);

                return mime.startsWith(prefix);
            }

            return mime === token;
        });
    }

    /**
     * @param {FileList | File[] | null | undefined} nextFiles
     * @param {{ append?: boolean }} [options]
     */
    function setFiles(nextFiles, options = {}) {
        const incoming = Array.from(nextFiles ?? []).filter(
            (file) => file instanceof File && matchesAccept(file, input.accept),
        );

        if (multiple && options.append) {
            const existingKeys = new Set(
                files.map((file) => `${file.name}:${file.size}:${file.lastModified}`),
            );

            incoming.forEach((file) => {
                const key = `${file.name}:${file.size}:${file.lastModified}`;
                if (! existingKeys.has(key)) {
                    files.push(file);
                    existingKeys.add(key);
                }
            });
        } else if (multiple) {
            files = incoming;
        } else {
            files = incoming.slice(0, 1);
        }

        syncInput();
        renderList();
        updateEmptyState();
    }

    /**
     * @param {{ dispatch?: boolean }} [options]
     */
    function syncInput(options = {}) {
        const transfer = new DataTransfer();

        files.forEach((file) => {
            transfer.items.add(file);
        });

        syncing = true;
        input.files = transfer.files;
        syncing = false;

        if (options.dispatch !== false) {
            dispatchValueEvents(input);
        }
    }

    function updateEmptyState() {
        const empty = files.length === 0;
        root.dataset.empty = empty ? 'true' : 'false';

        if (list instanceof HTMLElement) {
            list.hidden = empty;
        }
    }

    function renderList() {
        if (!(list instanceof HTMLElement) || !(template instanceof HTMLTemplateElement)) {
            return;
        }

        list.replaceChildren();

        files.forEach((file, index) => {
            const fragment = template.content.cloneNode(true);
            const item =
                fragment instanceof DocumentFragment
                    ? fragment.querySelector('[data-file-upload-item]')
                    : null;

            if (!(item instanceof HTMLElement)) {
                return;
            }

            item.dataset.index = String(index);

            const heading = item.querySelector('[data-file-upload-item-heading]');
            if (heading instanceof HTMLElement) {
                heading.textContent = file.name;
            }

            const text = item.querySelector('[data-file-upload-item-text]');
            if (text instanceof HTMLElement) {
                const label = formatBytes(file.size);
                text.textContent = label;
                text.hidden = label === '';
            }

            const remove = item.querySelector('[data-file-upload-item-remove]');
            if (remove instanceof HTMLButtonElement) {
                const baseLabel =
                    remove.getAttribute('aria-label')?.trim() || 'Remove';
                remove.setAttribute('aria-label', `${baseLabel}: ${file.name}`);
                remove.disabled = input.disabled;
            }

            list.appendChild(fragment);
        });
    }

    /**
     * @param {number} index
     */
    function removeAt(index) {
        if (index < 0 || index >= files.length) {
            return;
        }

        files.splice(index, 1);
        syncInput();
        renderList();
        updateEmptyState();
    }

    if (dropzone instanceof HTMLElement) {
        dropzone.addEventListener('click', (event) => {
            event.preventDefault();

            if (input.disabled || root.hasAttribute('data-disabled')) {
                return;
            }

            input.click();
        });

        dropzone.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            event.preventDefault();

            if (input.disabled || root.hasAttribute('data-disabled')) {
                return;
            }

            input.click();
        });

        ['dragenter', 'dragover'].forEach((type) => {
            dropzone.addEventListener(type, (event) => {
                event.preventDefault();
                event.stopPropagation();

                if (input.disabled || root.hasAttribute('data-disabled')) {
                    return;
                }

                dropzone.dataset.dragging = 'true';
            });
        });

        ['dragleave', 'dragend'].forEach((type) => {
            dropzone.addEventListener(type, (event) => {
                event.preventDefault();
                event.stopPropagation();
                dropzone.dataset.dragging = 'false';
            });
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            event.stopPropagation();
            dropzone.dataset.dragging = 'false';

            if (input.disabled || root.hasAttribute('data-disabled')) {
                return;
            }

            const dropped = event.dataTransfer?.files;
            setFiles(dropped, { append: multiple });
        });
    }

    input.addEventListener('change', () => {
        if (syncing || input.disabled) {
            return;
        }

        setFiles(input.files, { append: false });
    });

    if (list instanceof HTMLElement) {
        list.addEventListener('click', (event) => {
            const target =
                event.target instanceof Element
                    ? event.target.closest('[data-file-upload-item-remove]')
                    : null;

            if (!(target instanceof HTMLElement)) {
                return;
            }

            event.preventDefault();

            if (input.disabled || root.hasAttribute('data-disabled')) {
                return;
            }

            const item = target.closest('[data-file-upload-item]');
            if (!(item instanceof HTMLElement)) {
                return;
            }

            const index = Number.parseInt(item.dataset.index ?? '', 10);
            if (Number.isFinite(index)) {
                removeAt(index);
            }
        });
    }

    updateEmptyState();
    renderList();
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initFileUploads(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initFileUploads());
    } else {
        initFileUploads();
    }
}
