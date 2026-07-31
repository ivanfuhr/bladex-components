@props([
    'placeholder' => null,
])

@aware([
    'placeholder' => null,
])

@php
    $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;
@endphp

<span
    {{
        $attributes->class([
            'date-picker__value block min-w-0 flex-1 truncate',
            'data-placeholder:text-zinc-500 dark:data-placeholder:text-zinc-400',
        ])->merge([
            'data-placeholder' => $resolvedPlaceholder !== null ? 'true' : null,
        ])
    }}
    data-date-picker-value
>
    @if ($slot->isEmpty())
        {{ $resolvedPlaceholder }}
    @else
        {{ $slot }}
    @endif
</span>
