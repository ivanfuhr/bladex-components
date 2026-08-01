<span {{
    $attributes->class([
        'tooltip__trigger',
        'inline-flex',
    ])->merge([
        'data-tooltip-trigger' => true,
    ])
}}>
    {{ $slot }}
</span>
