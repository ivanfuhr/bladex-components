<li
    {{
        $attributes->class([
            'sidebar__menu-item',
            'group/menu-item relative',
        ])->merge([
            'data-sidebar-menu-item' => true,
        ])
    }}
>
    {{ $slot }}
</li>
