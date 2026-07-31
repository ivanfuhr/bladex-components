<div
    {{
        $attributes->class([
            'select__separator',
            '-mx-1 h-px shrink-0 bg-zinc-200 dark:bg-zinc-800',
        ])->merge([
            'role' => 'separator',
            'aria-orientation' => 'horizontal',
            'data-select-separator' => true,
        ])
    }}
></div>
