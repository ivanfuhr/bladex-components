<div {{
    $attributes->class([
        'sidebar__menu-badge',
        'pointer-events-none absolute right-1 top-1.5 flex h-5 min-w-5 items-center justify-center rounded-md px-1 text-xs font-medium tabular-nums select-none text-zinc-700',
        // group-has on menu-item (not peer): menu-button may sit inside tooltip display:contents wrappers.
        'group-hover/menu-item:text-zinc-950 group-has-data-[active=true]/menu-item:text-zinc-50',
        'dark:text-zinc-200 dark:group-hover/menu-item:text-zinc-50 dark:group-has-data-[active=true]/menu-item:text-zinc-900',
        'group-has-data-[size=sm]/menu-item:top-1',
        'group-has-data-[size=lg]/menu-item:top-2.5',
        // Icon mode: keep a recognition cue as a status dot (label lives in the menu tooltip).
        'group-data-[collapsible=icon]:top-1.5! group-data-[collapsible=icon]:right-1.5!',
        'group-data-[collapsible=icon]:h-2 group-data-[collapsible=icon]:min-w-2 group-data-[collapsible=icon]:w-2',
        'group-data-[collapsible=icon]:rounded-full group-data-[collapsible=icon]:p-0 group-data-[collapsible=icon]:text-[0px]',
        'group-data-[collapsible=icon]:leading-none group-data-[collapsible=icon]:bg-zinc-900',
        'dark:group-data-[collapsible=icon]:bg-zinc-50',
        'group-data-[collapsible=icon]:group-has-data-[active=true]/menu-item:bg-zinc-50',
        'dark:group-data-[collapsible=icon]:group-has-data-[active=true]/menu-item:bg-zinc-900',
    ])->merge([
        'data-sidebar-menu-badge' => true,
    ])
}}>
    {{ $slot }}
</div>
