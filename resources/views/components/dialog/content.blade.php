@props([
    'name' => null,
    'size' => 'default',
    'flyout' => false,
    'flyoutPosition' => 'right',
    'dismissible' => true,
    'closable' => true,
    'alert' => false,
    'open' => false,
    'preview' => false,
])

@aware([
    'name' => null,
])

@php
    $isFlyout = (bool) $flyout;
    $position = in_array($flyoutPosition, ['right', 'left', 'bottom'], true) ? $flyoutPosition : 'right';

    $dialogClasses = collect([
        'dialog__content',
        'fixed z-50 border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        'backdrop:bg-zinc-950/50 backdrop:backdrop-blur-[2px]',
        'motion-safe:transition-[opacity,transform] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]',
        'open:opacity-100 open:motion-safe:scale-100',
        'opacity-0 motion-safe:scale-[0.98]',
    ]);

    if ($isFlyout) {
        $dialogClasses->push('m-0 h-dvh max-h-dvh w-full max-w-md rounded-none');
        $dialogClasses->push(match ($position) {
            'left' => 'left-0 right-auto top-0 translate-x-0 translate-y-0',
            'bottom' => 'bottom-0 left-0 right-0 top-auto h-auto max-h-[85dvh] w-full max-w-none translate-x-0 translate-y-0 rounded-t-2xl',
            default => 'left-auto right-0 top-0 translate-x-0 translate-y-0',
        });
    } else {
        $dialogClasses->push('left-1/2 top-1/2 w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 rounded-xl');
        $dialogClasses->push($size === 'sm' ? 'max-w-sm' : 'max-w-lg');
    }

    $panelClasses = collect([
        'dialog__panel',
        'relative flex max-h-[min(85dvh,calc(100dvh-2rem))] flex-col p-6',
    ]);

    $closeButtonClasses = 'absolute right-4 top-4 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20';

    $isPreview = (bool) $preview;
    $isOpen = (bool) $open;

    // Render the slot once so title/description can mint their own ids, then
    // wire aria-labelledby / aria-describedby from those ids (avoids @aware
    // blind spots when ids are generated inside the parent view).
    $slotHtml = $slot->toHtml();

    $titleId = null;
    $descriptionId = null;

    if (preg_match('/\sdata-dialog-title="([^"]+)"/', $slotHtml, $titleMatch) === 1) {
        $titleId = $titleMatch[1];
    }

    if (preg_match('/\sdata-dialog-description="([^"]+)"/', $slotHtml, $descriptionMatch) === 1) {
        $descriptionId = $descriptionMatch[1];
    }
@endphp

@if ($isPreview)
    @php
        $previewPanelClasses = collect([
            'dialog__content',
            'relative z-10 w-full rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
            $size === 'sm' ? 'max-w-sm' : 'max-w-lg',
        ])->implode(' ');
    @endphp

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
                        <x-stencil::icon name="x" class="size-4" />
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
                    aria-label="{{ __('stencil::messages.dialog_close') }}"
                >
                    <x-stencil::icon name="x" class="size-4" />
                </button>
            @endif

            {!! $slotHtml !!}
        </div>
    </dialog>
@endif
