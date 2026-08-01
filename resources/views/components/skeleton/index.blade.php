@props([
    'rounded' => null,
])

@php
    $radius = match ($rounded) {
        'full', 'circle' => 'rounded-full',
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'lg' => 'rounded-lg',
        default => 'rounded-md',
    };
@endphp

<div
    {{
        $attributes->class([
            'skeleton',
            'animate-pulse bg-zinc-200 dark:bg-zinc-800',
            $radius,
        ])->merge([
            'data-skeleton' => true,
            'aria-hidden' => 'true',
        ])
    }}
></div>
