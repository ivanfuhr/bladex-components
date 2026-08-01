<div
    {{
        $attributes->class([
            'dropdown-menu__separator',
            '-mx-1 my-1 h-px bg-zinc-200 dark:bg-zinc-800',
        ])->merge([
            'role' => 'separator',
            'aria-orientation' => 'horizontal',
            'data-dropdown-menu-separator' => true,
        ])
    }}
></div>
