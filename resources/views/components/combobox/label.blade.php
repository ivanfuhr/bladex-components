@aware([
    'size' => null,
])

@php
    $labelClasses = collect([
        'combobox__label',
        'px-2 pb-0.5 pt-1',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class($labelClasses)->merge([
        'role' => 'presentation',
        'data-combobox-label' => true,
    ])
}}>
    <x-stencil::text size="sm" variant="subtle" inline class="text-xs">{{ $slot }}</x-stencil::text>
</div>
