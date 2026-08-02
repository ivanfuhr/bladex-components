@props([
    'name' => null,
    'title' => null,
    'description' => null,
    'shortcut' => null,
    'closable' => false,
    'dismissible' => true,
    'open' => false,
])

@php
    $resolvedTitle = filled($title)
        ? (string) $title
        : __('stencil::messages.command_palette_title');
    $resolvedDescription = filled($description)
        ? (string) $description
        : __('stencil::messages.command_palette_description');

    $dialogId = 'command-dialog-'.str_replace('.', '', uniqid('', true));
    $titleId = $dialogId.'-title';
    $descriptionId = $dialogId.'-description';

    $normalizedShortcut = filled($shortcut)
        ? strtolower(str_replace([' ', '+'], ['', '.'], (string) $shortcut))
        : null;

    if ($normalizedShortcut !== null) {
        $normalizedShortcut = str_replace(['cmd.', 'command.'], 'meta.', $normalizedShortcut);
    }

    $dialogClasses = collect([
        'command__dialog',
        'dialog__content',
        'fixed left-1/2 top-[12vh] z-50 w-[calc(100%-2rem)] max-w-lg -translate-x-1/2 overflow-hidden rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        'backdrop:bg-zinc-950/50 backdrop:backdrop-blur-[2px]',
        'motion-safe:transition-[opacity,transform] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]',
        'open:opacity-100 open:motion-safe:scale-100',
        'opacity-0 motion-safe:scale-[0.98]',
    ])->implode(' ');

    $closeButtonClasses = 'absolute right-3 top-2.5 z-10 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20';
@endphp

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
            <button
                type="button"
                class="{{ $closeButtonClasses }}"
                data-dialog-close
                aria-label="{{ __('stencil::messages.dialog_close') }}"
            >
                <x-stencil::icon name="x" class="size-4" />
            </button>
        @endif

        {{ $slot }}
    </div>
</dialog>
