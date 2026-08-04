<li {{
    $attributes->class([
        'sidebar__menu-item',
        'group/menu-item relative flex w-full min-w-0',
        'group-data-[collapsible=icon]:w-auto group-data-[collapsible=icon]:justify-center',
    ])->merge([
        'data-sidebar-menu-item' => true,
    ])
}}>
    {{ $slot }}
</li>
