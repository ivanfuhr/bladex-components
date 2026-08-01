<div {{
    $attributes->class([
        'dropdown-menu__trigger',
        'contents',
    ])->merge([
        'data-dropdown-menu-trigger' => true,
    ])
}}>
    {{ $slot }}
</div>
