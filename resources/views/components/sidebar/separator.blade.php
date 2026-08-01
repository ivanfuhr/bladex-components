<div
    {{
        $attributes->class([
            'sidebar__separator',
            'mx-2 w-auto shrink-0 bg-zinc-200 dark:bg-zinc-800',
            'h-px',
        ])->merge([
            'data-sidebar-separator' => true,
            'data-separator' => true,
            'role' => 'separator',
            'aria-orientation' => 'horizontal',
        ])
    }}
></div>
