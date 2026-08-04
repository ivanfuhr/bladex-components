<span {{
    $attributes->class([
        'stat__trend',
        'inline-flex items-center gap-1 text-xs font-medium tabular-nums',
        $directionClasses,
    ])->merge([
        'data-stat-trend' => true,
        'data-direction' => filled($direction) ? (string) $direction : null,
    ])
}}>
    @if (filled($directionLabel))
        <span class="sr-only">{{ $directionLabel }}: </span>
    @endif
    {{ $slot }}
</span>
