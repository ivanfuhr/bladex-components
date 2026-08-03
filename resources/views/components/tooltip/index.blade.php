<span {{
    $attributes->class([
        'tooltip',
        'relative inline-flex',
    ])->merge([
        'data-tooltip' => true,
        'data-side' => $side,
        'data-delay' => (string) $delay,
    ])
}}>
    {{ $slot }}
</span>
