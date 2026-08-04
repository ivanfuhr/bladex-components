<ul {{
    $attributes->class([
        'sidebar__menu',
        'flex w-full min-w-0 flex-col gap-1',
        'group-data-[collapsible=icon]:items-center',
    ])->merge([
        'data-sidebar-menu' => true,
    ])
}}>
    {{ $slot }}
</ul>
