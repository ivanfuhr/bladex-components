/**
 * Std Components — avatar image fallback (vanilla JS, no Alpine).
 */

const AVATAR_SELECTOR = '[data-avatar]';
const IMAGE_SELECTOR = '[data-avatar-image]';
const FALLBACK_SELECTOR = '[data-avatar-fallback]';
const initialized = new WeakSet();

/**
 * @param {ParentNode} root
 */
export function initAvatars(root = document) {
    root.querySelectorAll(AVATAR_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        if (initialized.has(element)) {
            return;
        }

        initialized.add(element);
        bindAvatar(element);
    });
}

/**
 * @param {HTMLElement} avatar
 */
function bindAvatar(avatar) {
    const image = avatar.querySelector(IMAGE_SELECTOR);
    const fallback = avatar.querySelector(FALLBACK_SELECTOR);

    if (!(image instanceof HTMLImageElement) || !(fallback instanceof HTMLElement)) {
        return;
    }

    fallback.hidden = true;

    const hideImage = () => {
        image.hidden = true;
        image.classList.add('hidden');
        fallback.hidden = false;
        fallback.classList.remove('hidden');
    };

    if (image.complete && image.naturalWidth === 0) {
        hideImage();

        return;
    }

    image.addEventListener('error', hideImage, { once: true });
}

document.addEventListener('std:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initAvatars(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initAvatars());
    } else {
        initAvatars();
    }
}
