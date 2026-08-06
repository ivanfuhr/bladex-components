/**
 * Per-root AbortSignal for document/window listeners.
 * Aborts when the root disconnects, or when rebound on the same element.
 */

/** @type {WeakMap<HTMLElement, AbortController>} */
const controllers = new WeakMap();

/**
 * @param {HTMLElement} root
 * @returns {AbortSignal}
 */
export function createBindSignal(root) {
    controllers.get(root)?.abort();

    const controller = new AbortController();
    controllers.set(root, controller);

    const disconnectObserver = new MutationObserver(() => {
        if (!root.isConnected) {
            controller.abort();
        }
    });

    disconnectObserver.observe(document.documentElement, { childList: true, subtree: true });

    controller.signal.addEventListener(
        'abort',
        () => {
            disconnectObserver.disconnect();

            if (controllers.get(root) === controller) {
                controllers.delete(root);
            }
        },
        { once: true },
    );

    return controller.signal;
}
