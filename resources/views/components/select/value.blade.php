@aware([
    'placeholder' => null,
    'size' => null,
])

@props([
    'placeholder' => null,
])

@php
    $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;

    $valueClasses = collect([
        'select__value',
        'block min-w-0 flex-1 truncate',
        'data-placeholder:text-zinc-500 dark:data-placeholder:text-zinc-400',
    ])->implode(' ');
@endphp

<span
    {{
        $attributes->class($valueClasses)->merge([
            'data-placeholder' => $resolvedPlaceholder !== null ? 'true' : null,
        ])
    }}
    data-select-value
>
    @if ($slot->isEmpty())
        {{ $resolvedPlaceholder }}
    @else
        {{ $slot }}
    @endif
</span>
