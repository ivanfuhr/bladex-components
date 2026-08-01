@props([
    'value' => 0,
    'max' => 100,
    'indeterminate' => false,
    'size' => null,
])

@php
    $max = max(1, (float) $max);
    $value = max(0, min($max, (float) $value));
    $percent = $indeterminate ? null : round(($value / $max) * 100, 2);
    $height = $size === 'sm' ? 'h-1.5' : ($size === 'lg' ? 'h-3' : 'h-2');
@endphp

<div {{
    $attributes->class([
        'progress',
        'relative w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800',
        $height,
    ])->merge([
        'role' => 'progressbar',
        'aria-valuemin' => '0',
        'aria-valuemax' => (string) $max,
        'aria-valuenow' => $indeterminate ? null : (string) $value,
        'data-progress' => true,
        'data-indeterminate' => $indeterminate ? 'true' : null,
    ])
}}>
    <div
        @class([
            'progress__indicator',
            'h-full rounded-full bg-zinc-900 transition-[width] duration-300 ease-out dark:bg-zinc-100',
            $indeterminate ? 'w-1/3 animate-pulse' : null,
        ])
        data-progress-indicator
        @if (! $indeterminate)
            style="width: {{ $percent }}%"
        @endif
    ></div>
</div>
