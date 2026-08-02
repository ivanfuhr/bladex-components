<li {{
    $attributes->class([
        'sidebar__menu-sub-item',
        'group/menu-sub-item relative',
    ])->merge([
        'data-sidebar-menu-sub-item' => true,
    ])
}}>
    {{ $slot }}
</li>
