@props([
    'direction' => null,
])

@php
    $directionClasses = match ($direction) {
        'up' => 'text-emerald-700 dark:text-emerald-400',
        'down' => 'text-red-700 dark:text-red-400',
        'neutral' => 'text-zinc-600 dark:text-zinc-300',
        default => 'text-zinc-600 dark:text-zinc-300',
    };
@endphp

<span
    {{
        $attributes->class([
            'stat__trend',
            'inline-flex items-center gap-1 text-xs font-medium tabular-nums',
            $directionClasses,
        ])->merge([
            'data-stat-trend' => true,
            'data-direction' => filled($direction) ? (string) $direction : null,
        ])
    }}
>{{ $slot }}</span>
