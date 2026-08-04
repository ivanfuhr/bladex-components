<button
    type="button"
    {{
        $attributes->class([
            'sidebar__rail',
            'absolute inset-y-0 z-20 hidden w-4 -translate-x-1/2 transition-all ease-out sm:flex',
            'group-data-[side=left]:-right-4 group-data-[side=right]:left-0',
            'after:absolute after:inset-y-0 after:left-1/2 after:w-0.5 hover:after:bg-zinc-300 dark:hover:after:bg-zinc-700',
            '[[data-side=left]_&]:cursor-w-resize [[data-side=right]_&]:cursor-e-resize',
            '[[data-side=left][data-state=collapsed]_&]:cursor-e-resize [[data-side=right][data-state=collapsed]_&]:cursor-w-resize',
            'group-data-[collapsible=offcanvas]:translate-x-0 group-data-[collapsible=offcanvas]:after:left-full',
            'hover:group-data-[collapsible=offcanvas]:bg-zinc-100 dark:hover:group-data-[collapsible=offcanvas]:bg-zinc-800',
        ])->merge([
            'data-sidebar-rail' => true,
            'aria-label' => $attributes->get('aria-label', 'Toggle sidebar'),
            'title' => $attributes->get('title', 'Toggle sidebar'),
            'tabindex' => '-1',
            'aria-expanded' => $isExpanded ? 'true' : 'false',
        ])
    }}
></button>
