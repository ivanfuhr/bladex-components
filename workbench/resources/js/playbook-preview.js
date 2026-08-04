/**
 * Live preview Alpine controller for /playbook/{component}.
 *
 * Widget modules are imported for side effects so each registers its
 * DOMContentLoaded + stencil:mount handlers (same contract as the CDN bundle).
 * After Alpine x-html injects preview markup, we re-dispatch stencil:mount
 * instead of calling every init* by hand — new widgets that listen for the
 * event are covered automatically.
 *
 * Playbook chrome must not also load @stencilScripts: a second copy of each
 * widget would bind again (separate WeakSet) and toggles would fire twice.
 */

import '../views/ui/select/select.js';
import '../views/ui/combobox/combobox.js';
import '../views/ui/file-upload/file-upload.js';
import '../views/ui/repeater/repeater.js';
import '../views/ui/input-otp/input-otp.js';
import '../views/ui/slider/slider.js';
import '../views/ui/dialog/dialog.js';
import '../../../resources/assets/js/command.js';
import '../views/ui/date-picker/date-picker.js';
import '../views/ui/calendar/calendar.js';
import '../views/ui/time-picker/time-picker.js';
import '../views/ui/datetime-picker/datetime-picker.js';
import '../views/ui/input/input-currency.js';
import '../views/ui/pillbox/pillbox.js';
import '../views/ui/rating/rating.js';
import '../views/ui/color-picker/color-picker.js';
import '../views/ui/input/input-enhancements.js';
import '../views/ui/textarea/textarea.js';
import '../../../resources/assets/js/accordion.js';
import '../../../resources/assets/js/collapsible.js';
import '../../../resources/assets/js/code-block.js';
import '../../../resources/assets/js/scroll-area.js';
import '../../../resources/assets/js/sidebar.js';
import '../../../resources/assets/js/avatar.js';
import '../../../resources/assets/js/dropdown-menu.js';
import '../../../resources/assets/js/popover.js';
import '../../../resources/assets/js/tabs.js';
import '../../../resources/assets/js/toggle.js';
import '../../../resources/assets/js/toggle-group.js';
import '../../../resources/assets/js/stepper.js';
import '../../../resources/assets/js/tooltip.js';
import '../../../resources/assets/js/chart.js';
import '../../../resources/assets/js/toast.js';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('playbookPreview', (config) => ({
        component: config.component,
        state: config.state,
        previewUrl: config.previewUrl,
        html: config.initialHtml,
        snippet: config.initialSnippet ?? '',
        snippetHtml: config.initialSnippetHtml ?? '',
        loading: false,
        copied: false,
        copyFailed: false,
        error: null,
        statusMessage: '',
        timer: null,
        abortController: null,
        statusClearTimer: null,

        init() {
            this.$watch('html', () => {
                this.schedulePreviewWidgets();
            });

            this.$watch('snippetHtml', () => {
                this.scheduleSnippetWidgets();
            });

            this.schedulePreviewWidgets();
            this.scheduleSnippetWidgets();
        },

        scheduleSnippetWidgets() {
            this.$nextTick(() => {
                this.$nextTick(() => {
                    requestAnimationFrame(() => this.bindSnippetWidgets());
                });
            });
        },

        bindSnippetWidgets() {
            const snippetRoot = document.querySelector('[data-playbook-snippet]');

            if (!(snippetRoot instanceof HTMLElement)) {
                return;
            }

            document.dispatchEvent(
                new CustomEvent('stencil:mount', {
                    detail: { root: snippetRoot },
                }),
            );
        },

        schedulePreviewWidgets() {
            // x-html applies after Alpine's first tick; wait for DOM before binding widgets.
            this.$nextTick(() => {
                this.$nextTick(() => {
                    requestAnimationFrame(() => this.bindPreviewWidgets());
                });
            });
        },

        bindPreviewWidgets() {
            const canvas = document.getElementById('playbook-canvas');
            if (!canvas) {
                return;
            }

            document.querySelectorAll('[data-select-portaled]').forEach((element) => {
                element.remove();
            });

            document.querySelectorAll('[data-combobox-portaled]').forEach((element) => {
                element.remove();
            });

            document.querySelectorAll('[data-color-picker-portaled]').forEach((element) => {
                element.remove();
            });

            document.querySelectorAll('[data-dropdown-menu-portaled]').forEach((element) => {
                element.remove();
            });

            document.dispatchEvent(
                new CustomEvent('stencil:mount', {
                    detail: { root: canvas },
                }),
            );
        },

        queuePreview() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.refreshPreview(), 150);
        },

        setStatus(message, { clearAfterMs = 0 } = {}) {
            clearTimeout(this.statusClearTimer);
            this.statusMessage = message;

            if (clearAfterMs > 0) {
                this.statusClearTimer = setTimeout(() => {
                    this.statusMessage = '';
                }, clearAfterMs);
            }
        },

        copyLabel() {
            if (this.copyFailed) {
                return 'Copy failed';
            }

            return this.copied ? 'Copied' : 'Copy';
        },

        async refreshPreview() {
            this.abortController?.abort();
            this.abortController = new AbortController();
            const { signal } = this.abortController;

            this.loading = true;
            this.error = null;
            this.setStatus('Updating preview…');

            try {
                const token =
                    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ??
                    '';

                const response = await fetch(this.previewUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        component: this.component,
                        state: this.state,
                    }),
                    signal,
                });

                if (!response.ok) {
                    throw new Error('Preview request failed');
                }

                const data = await response.json();
                this.html = data.html;
                this.snippet = data.snippet ?? '';
                this.snippetHtml = data.snippetHtml ?? '';
                this.error = null;
                this.setStatus('Preview updated', { clearAfterMs: 1500 });
            } catch (error) {
                if (error?.name === 'AbortError') {
                    return;
                }

                this.error = 'Preview failed to update. Try changing a property again.';
                this.setStatus('Preview failed');
            } finally {
                if (!signal.aborted) {
                    this.loading = false;
                }
            }
        },

        async copySnippet() {
            if (!this.snippet) {
                return;
            }

            try {
                await navigator.clipboard.writeText(this.snippet);
                this.copied = true;
                this.copyFailed = false;
                this.setStatus('Code copied', { clearAfterMs: 2000 });
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch {
                this.copied = false;
                this.copyFailed = true;
                this.setStatus('Copy failed', { clearAfterMs: 2500 });
                setTimeout(() => {
                    this.copyFailed = false;
                }, 2500);
            }
        },
    }));
});
