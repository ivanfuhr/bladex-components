@props([
    'value' => null,
    'heading' => null,
    'expanded' => false,
    'disabled' => false,
    'triggerId' => null,
    'contentId' => null,
])

@aware([
    'variant' => null,
    'transition' => false,
])

@php
    $itemValue = filled($value) ? (string) $value : 'accordion-item-'.str_replace('.', '', uniqid('', true));
    $isExpanded = (bool) $expanded;
    $isDisabled = (bool) $disabled;
    $itemId = 'accordion-'.str_replace('.', '', uniqid('', true));
    $triggerId ??= $itemId.'-trigger';
    $contentId ??= $itemId.'-content';
@endphp

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
        <x-stencil::accordion.trigger> {{ $heading }} </x-stencil::accordion.trigger>
        <x-stencil::accordion.content> {{ $slot }} </x-stencil::accordion.content>
    @else
        {{ $slot }}
    @endif
</div>
