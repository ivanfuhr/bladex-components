<div
    {{
        $attributes->class([
            'datetime-picker__panel z-50 max-w-[calc(100vw-2rem)] overflow-hidden rounded-xl border border-zinc-200 bg-white p-0 shadow-xl dark:border-zinc-800 dark:bg-zinc-950',
        ])
    }}
    @if (filled($panelId)) id="{{ $panelId }}" @endif
    data-datetime-picker-panel
    hidden
    aria-hidden="true"
    tabindex="-1"
    aria-label="{{ $panelLabel }}"
>
    {{ $slot }}
</div>
