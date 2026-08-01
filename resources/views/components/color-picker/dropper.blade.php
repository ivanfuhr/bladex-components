@aware([
    'disabled' => false,
])

<button
    type="button"
    {{ $attributes->class([
        'inline-flex size-9 shrink-0 items-center justify-center rounded-md border border-zinc-200 text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-zinc-950 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
    ]) }}
    data-color-picker-dropper
    aria-label="{{ __('stencil::messages.color_picker_dropper') }}"
    hidden
    @if ($disabled) disabled @endif
>
    <x-stencil::icon.lucide class="size-4">
        <path d="m2 22 1-1h3l9.5-9.5a2.12 2.12 0 0 0-3-3L3 18v3Z" />
        <path d="M15 6l3 3" />
        <path d="m18 3 3 3" />
    </x-stencil::icon.lucide>
</button>
