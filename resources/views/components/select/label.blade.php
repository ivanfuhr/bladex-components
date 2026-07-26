@aware([
    'size' => null,
])

@php
    $labelClasses = collect([
        'select__label',
        'px-2 py-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400',
    ])->implode(' ');
@endphp

<div
    {{ $attributes->class($labelClasses)->merge([
        'role' => 'presentation',
        'data-select-label' => true,
    ]) }}
>
    {{ $slot }}
</div>
