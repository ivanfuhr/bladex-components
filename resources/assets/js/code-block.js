/**
 * Std Components — code block copy button (vanilla JS, no Alpine).
 */

const CODE_BLOCK_SELECTOR = '[data-code-block]';
const COPY_SELECTOR = '[data-code-block-copy]';
const SOURCE_SELECTOR = '[data-code-block-source]';
const CONTENT_SELECTOR = '[data-code-block-content]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initCodeBlocks(root = document) {
    root.querySelectorAll(CODE_BLOCK_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindCodeBlock(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindCodeBlock(root) {
    const copyButton = root.querySelector(COPY_SELECTOR);

    if (!(copyButton instanceof HTMLButtonElement)) {
        return;
    }

    const defaultLabel = copyButton.textContent?.trim() || 'Copy';

    copyButton.addEventListener('click', async () => {
        const source = root.querySelector(SOURCE_SELECTOR);
        const content = root.querySelector(CONTENT_SELECTOR);

        const text =
            source instanceof HTMLTemplateElement
                ? (source.content.textContent ?? '')
                : content instanceof HTMLElement
                  ? (content.textContent ?? '')
                  : '';

        if (text === '') {
            return;
        }

        try {
            await navigator.clipboard.writeText(text);
            copyButton.textContent = 'Copied';
            window.setTimeout(() => {
                copyButton.textContent = defaultLabel;
            }, 1600);
        } catch {
            copyButton.textContent = 'Failed';
            window.setTimeout(() => {
                copyButton.textContent = defaultLabel;
            }, 1600);
        }
    });
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initCodeBlocks(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCodeBlocks());
    } else {
        initCodeBlocks();
    }
}
