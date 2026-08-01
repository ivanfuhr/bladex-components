import { initSelects } from '../views/ui/select/select.js';
import { initComboboxes } from '../views/ui/combobox/combobox.js';
import { initFileUploads } from '../views/ui/file-upload/file-upload.js';
import { initRepeaters } from '../views/ui/repeater/repeater.js';
import { initInputOtps } from '../views/ui/input-otp/input-otp.js';
import { initSliders } from '../views/ui/slider/slider.js';
import { initDialogs } from '../views/ui/dialog/dialog.js';
import { initDatePickers } from '../views/ui/date-picker/date-picker.js';
import { initCalendars } from '../views/ui/date-picker/calendar.js';
import { initTimePickers } from '../views/ui/time-picker/time-picker.js';
import { initDatetimePickers } from '../views/ui/datetime-picker/datetime-picker.js';
import { initInputCurrencies } from '../views/ui/input/input-currency.js';
import { initPillboxes } from '../views/ui/pillbox/pillbox.js';
import { initRatings } from '../views/ui/rating/rating.js';
import { initColorPickers } from '../views/ui/color-picker/color-picker.js';
import { initInputEnhancements } from '../views/ui/input/input-enhancements.js';
import { initTextareas } from '../views/ui/textarea/textarea.js';
import { initAccordions } from '../../../resources/assets/js/accordion.js';
import { initCollapsibles } from '../../../resources/assets/js/collapsible.js';
import { initAvatars } from '../../../resources/assets/js/avatar.js';
import { initDropdownMenus } from '../../../resources/assets/js/dropdown-menu.js';
import { initTabs } from '../../../resources/assets/js/tabs.js';
import { initTooltips } from '../../../resources/assets/js/tooltip.js';
import { initToasts } from '../../../resources/assets/js/toast.js';

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

            initSelects(canvas);
            initComboboxes(canvas);
            initFileUploads(canvas);
            initRepeaters(canvas);
            initInputOtps(canvas);
            initSliders(canvas);
            initDialogs(canvas);
            initCalendars(canvas);
            initDatePickers(canvas);
            initTimePickers(canvas);
            initDatetimePickers(canvas);
            initInputCurrencies(canvas);
            initPillboxes(canvas);
            initRatings(canvas);
            initColorPickers(canvas);
            initInputEnhancements(canvas);
            initTextareas(canvas);
            initAccordions(canvas);
            initCollapsibles(canvas);
            initAvatars(canvas);
            initDropdownMenus(canvas);
            initTabs(canvas);
            initTooltips(canvas);
            initToasts(canvas);
        },

        queuePreview() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.refreshPreview(), 150);
        },

        async refreshPreview() {
            this.loading = true;

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
                });

                if (!response.ok) {
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
            if (!this.snippet) {
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
