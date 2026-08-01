@props([
    'value',
])

@aware([
    'defaultValue' => null,
])

@php
    $isSelected = filled($defaultValue) && (string) $value === (string) $defaultValue;
@endphp

<div {{
    $attributes->class([
        'tabs__content',
        'mt-2 text-sm text-zinc-700 focus-visible:outline-none dark:text-zinc-300',
        ! $isSelected ? 'hidden' : null,
    ])->merge([
        'role' => 'tabpanel',
        'data-tabs-content' => true,
        'data-value' => $value,
        'data-state' => $isSelected ? 'active' : 'inactive',
        'tabindex' => '0',
        'hidden' => $isSelected ? null : true,
    ])
}}>
    {{ $slot }}
</div>
