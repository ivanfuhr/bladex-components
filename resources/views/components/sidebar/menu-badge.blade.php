<div {{
    $attributes->class([
        'sidebar__menu-badge',
        'pointer-events-none absolute right-1 flex h-5 min-w-5 items-center justify-center rounded-md px-1 text-xs font-medium tabular-nums select-none text-zinc-700',
        'peer-hover/menu-button:text-zinc-950 peer-data-[active=true]/menu-button:text-zinc-950',
        'dark:text-zinc-200 dark:peer-hover/menu-button:text-zinc-50 dark:peer-data-[active=true]/menu-button:text-zinc-50',
        'peer-data-[size=sm]/menu-button:top-1',
        'peer-data-[size=default]/menu-button:top-1.5',
        'peer-data-[size=lg]/menu-button:top-2.5',
        'group-data-[collapsible=icon]:hidden',
    ])->merge([
        'data-sidebar-menu-badge' => true,
    ])
}}>
    {{ $slot }}
</div>
