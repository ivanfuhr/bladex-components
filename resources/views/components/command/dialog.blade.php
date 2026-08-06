<dialog {{
    $attributes->class($dialogClasses)->merge([
        'data-dialog-content' => true,
        'data-command-dialog' => true,
        'data-dialog-dismissible' => $dismissible ? 'true' : 'false',
        'data-dialog-name' => filled($name) ? $name : null,
        'data-command-shortcut' => $normalizedShortcut,
        'aria-modal' => 'true',
        'aria-labelledby' => $titleId,
        'aria-describedby' => $descriptionId,
        'role' => 'dialog',
        'open' => $open ? true : null,
    ])
}}>
    <div
        class="dialog__panel relative flex max-h-[min(76vh,calc(100dvh-4rem))] flex-col overflow-hidden p-0"
        data-dialog-panel
    >
        <h2 id="{{ $titleId }}" class="sr-only" data-dialog-title="{{ $titleId }}">{{ $resolvedTitle }}</h2>
        <p id="{{ $descriptionId }}" class="sr-only" data-dialog-description="{{ $descriptionId }}">
            {{ $resolvedDescription }}
        </p>

        @if ($closable)
            <button type="button" class="{{ $closeButtonClasses }}" data-dialog-close aria-label="{{ __('Close') }}">
                <x-std::icon name="x" class="size-4" />
            </button>
        @endif

        {{ $slot }}
    </div>
</dialog>
