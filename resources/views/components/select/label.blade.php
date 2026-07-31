@aware([
    'size' => null,
])

@php
    $labelClasses = collect([
        'select__label',
        'px-2 pb-0.5 pt-1',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class($labelClasses)->merge([
        'role' => 'presentation',
        'data-select-label' => true,
    ])
}}>
    <x-stencil::text size="sm" variant="subtle" inline class="text-xs">{{ $slot }}</x-stencil::text>
</div>
