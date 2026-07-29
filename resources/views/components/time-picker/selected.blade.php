@props([
    'placeholder' => null,
])

<span
    {{ $attributes->class([
        'time-picker__value block min-w-0 flex-1 truncate text-left',
        'data-placeholder:text-zinc-500 dark:data-placeholder:text-zinc-400',
    ])->merge([
        'data-placeholder' => filled($placeholder) ? 'true' : null,
    ]) }}
    data-time-picker-value
>{{ $placeholder }}</span>
