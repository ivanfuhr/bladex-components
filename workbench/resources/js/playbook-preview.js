document.addEventListener('alpine:init', () => {
    window.Alpine.data('playbookPreview', (config) => ({
        component: config.component,
        state: config.state,
        previewUrl: config.previewUrl,
        html: config.initialHtml,
        loading: false,
        timer: null,

        init() {},

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
            } finally {
                this.loading = false;
            }
        },
    }));
});
