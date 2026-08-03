<div {{
    $attributes->class([
        'dropdown-menu',
        'relative inline-flex',
    ])->merge([
        'data-dropdown-menu' => true,
        'data-align' => $align,
        'data-side' => $side,
    ])
}}>
    {{ $slot }}
</div>
