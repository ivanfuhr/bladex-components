@props([
    'open' => false,
    'disabled' => false,
    'transition' => false,
])

@php
    $isOpen = (bool) $open;
    $isDisabled = (bool) $disabled;
    $baseId = 'collapsible-'.str_replace('.', '', uniqid('', true));
@endphp

<div {{
    $attributes->class([
        'collapsible',
        'w-full',
    ])->merge([
        'data-collapsible' => true,
        'data-state' => $isOpen ? 'open' : 'closed',
        'data-collapsible-transition' => $transition ? 'true' : 'false',
        'data-collapsible-disabled' => $isDisabled ? 'true' : null,
        'data-collapsible-trigger-id' => $baseId.'-trigger',
        'data-collapsible-content-id' => $baseId.'-content',
    ])
}}>
    {{ $slot }}
</div>
