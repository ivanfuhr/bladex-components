<div {{
    $attributes->class([
        'popover__trigger',
        'contents',
    ])->merge([
        'data-popover-trigger' => true,
    ])
}}>
    {{ $slot }}
</div>
