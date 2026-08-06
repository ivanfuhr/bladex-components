<button
    type="button"
    {{
        $attributes->class([
            'badge__close',
            '-me-0.5 inline-flex size-8 min-h-8 min-w-8 items-center justify-center rounded-sm opacity-70 transition hover:opacity-100',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
        ])->merge([
            'data-badge-close' => true,
            'aria-label' => __('Remove'),
        ])
    }}
>
    @if ($slot->isEmpty())
        <x-std::icon name="x" class="size-3.5" />
    @else
        {{ $slot }}
    @endif
</button>
