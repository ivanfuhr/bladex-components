<div
    {{ $attributes->class([
        'select__separator',
        'my-1 h-px bg-zinc-200 dark:bg-zinc-800',
    ])->merge([
        'role' => 'separator',
        'aria-orientation' => 'horizontal',
        'data-select-separator' => true,
    ]) }}
></div>
