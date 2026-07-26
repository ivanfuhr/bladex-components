import { initSelects } from '../../../resources/assets/js/select.js';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('playbookPreview', (config) => ({
        component: config.component,
        state: config.state,
        previewUrl: config.previewUrl,
        html: config.initialHtml,
        snippet: config.initialSnippet ?? '',
        loading: false,
        copied: false,
        timer: null,

        init() {
            this.$watch('html', () => {
                this.schedulePreviewWidgets();
            });

            this.schedulePreviewWidgets();
        },

        schedulePreviewWidgets() {
            // x-html applies after Alpine's first tick; wait for DOM before binding select.js.
            this.$nextTick(() => {
                this.$nextTick(() => {
                    requestAnimationFrame(() => this.bindPreviewWidgets());
                });
            });
        },

        bindPreviewWidgets() {
            const canvas = document.getElementById('playbook-canvas');
            if (! canvas) {
                return;
            }

            document.querySelectorAll('[data-select-portaled]').forEach((element) => {
                element.remove();
            });

            initSelects(canvas);
        },

        queuePreview() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.refreshPreview(), 150);
        },

        async refreshPreview() {
            this.loading = true;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

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
                });

                if (! response.ok) {
                    throw new Error('Preview request failed');
                }

                const data = await response.json();
                this.html = data.html;
                this.snippet = data.snippet ?? '';
            } finally {
                this.loading = false;
            }
        },

        async copySnippet() {
            if (! this.snippet) {
                return;
            }

            try {
                await navigator.clipboard.writeText(this.snippet);
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch {
                //
            }
        },
    }));
});
