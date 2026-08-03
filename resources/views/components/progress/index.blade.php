<div {{
    $attributes->class([
        'progress',
        'relative w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800',
        $height,
    ])->merge([
        'role' => 'progressbar',
        'aria-valuemin' => '0',
        'aria-valuemax' => (string) $resolvedMax,
        'aria-valuenow' => $indeterminate ? null : (string) $resolvedValue,
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
