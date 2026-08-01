<ul
    {{
        $attributes->class([
            'sidebar__menu-sub',
            'mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l border-zinc-200 px-2.5 py-0.5',
            'dark:border-zinc-800',
            'group-data-[collapsible=icon]:hidden',
        ])->merge([
            'data-sidebar-menu-sub' => true,
        ])
    }}
>
    {{ $slot }}
</ul>
