@if ($isPreview)
    <div {{
        $attributes->class([
            'dialog__preview',
            'relative flex min-h-[18rem] w-full items-center justify-center overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100/60 p-6 dark:border-zinc-800 dark:bg-zinc-900/60',
        ])
    }}>
        <div
            class="pointer-events-none absolute inset-0 bg-zinc-950/50 backdrop-blur-[2px] dark:bg-zinc-950/60"
            aria-hidden="true"
        ></div>

        <div
            class="{{ $previewPanelClasses }}"
            role="{{ $alert ? 'alertdialog' : 'dialog' }}"
            aria-modal="true"
            @if (filled($titleId)) aria-labelledby="{{ $titleId }}" @endif
            @if (filled($descriptionId)) aria-describedby="{{ $descriptionId }}" @endif
            data-dialog-content
            data-dialog-preview
        >
            <div @class($panelClasses->all()) data-dialog-panel>
                @if ($closable)
                    <button
                        type="button"
                        class="{{ $closeButtonClasses }}"
                        data-dialog-close
                        tabindex="-1"
                        aria-hidden="true"
                        disabled
                    >
                        <x-ui::icon name="x" class="size-4" />
                    </button>
                @endif

                {!! $slotHtml !!}
            </div>
        </div>
    </div>
@else
    <dialog {{
        $attributes->class($dialogClasses->all())->merge([
            'data-dialog-content' => true,
            'data-dialog-dismissible' => $dismissible ? 'true' : 'false',
            'data-dialog-name' => filled($name) ? $name : null,
            'data-dialog-flyout' => $isFlyout ? 'true' : 'false',
            'aria-modal' => 'true',
            'aria-labelledby' => filled($titleId) ? $titleId : null,
            'aria-describedby' => filled($descriptionId) ? $descriptionId : null,
            'role' => $alert ? 'alertdialog' : 'dialog',
            'open' => $isOpen ? true : null,
        ])
    }}>
        <div @class($panelClasses->all()) data-dialog-panel>
            @if ($closable)
                <button
                    type="button"
                    class="{{ $closeButtonClasses }}"
                    data-dialog-close
                    aria-label="{{ __('Close') }}"
                >
                    <x-ui::icon name="x" class="size-4" />
                </button>
            @endif

            {!! $slotHtml !!}
        </div>
    </dialog>
@endif
