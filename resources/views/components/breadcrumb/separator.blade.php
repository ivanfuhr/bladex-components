<li {{
    $attributes->class([
        'breadcrumb__separator',
        'shrink-0 items-center',
    ])->merge([
        'role' => 'presentation',
        'aria-hidden' => 'true',
        'data-breadcrumb-separator' => true,
    ])
}}>
    @if (! $slot->isEmpty())
        {{ $slot }}
    @elseif ($type === 'slash')
        <span class="text-zinc-400 dark:text-zinc-500">/</span>
    @else
        <x-std::icon name="chevron-right" class="size-3.5 text-zinc-400 dark:text-zinc-500" />
    @endif
</li>
