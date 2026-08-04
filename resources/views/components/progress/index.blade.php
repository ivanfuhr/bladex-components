<div {{
    $attributes->class([
        'progress',
        'relative w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800',
        $height,
    ])->merge(array_filter([
        'role' => 'progressbar',
        'aria-label' => $accessibleLabel,
        'aria-valuemin' => '0',
        'aria-valuemax' => (string) $resolvedMax,
        'aria-valuenow' => $indeterminate ? null : (string) $resolvedValue,
        'aria-valuetext' => $valueText,
        'aria-busy' => $indeterminate ? 'true' : null,
        'data-progress' => true,
        'data-indeterminate' => $indeterminate ? 'true' : null,
    ]))
}}>
    <div
        @class([
            'progress__indicator',
            'h-full rounded-full bg-zinc-900 transition-[width] duration-300 ease-out dark:bg-zinc-100',
        ])
        data-progress-indicator
        @if (! $indeterminate)
            style="width: {{ $percent }}%"
        @endif
    ></div>
</div>
