@aware([
    'size' => null,
])

@php
    $labelClasses = collect([
        'select__label',
        'px-2 pb-0.5 pt-1 text-xs font-medium text-zinc-500 dark:text-zinc-400',
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
