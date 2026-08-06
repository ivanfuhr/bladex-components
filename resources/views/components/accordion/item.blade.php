<div {{
    $attributes->class([
        'accordion__item',
        'border-b border-zinc-200 last:border-b-0 dark:border-zinc-800',
    ])->merge([
        'data-accordion-item' => true,
        'data-accordion-value' => $itemValue,
        'data-state' => $isExpanded ? 'open' : 'closed',
        'data-accordion-disabled' => $isDisabled ? 'true' : null,
    ])
}}>
    @if (filled($heading))
        <x-std::accordion.trigger> {{ $heading }} </x-std::accordion.trigger>
        <x-std::accordion.content> {{ $slot }} </x-std::accordion.content>
    @else
        {{ $slot }}
    @endif
</div>
