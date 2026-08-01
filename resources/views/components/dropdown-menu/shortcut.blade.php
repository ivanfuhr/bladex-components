<span {{
    $attributes->class([
        'dropdown-menu__shortcut',
        'ms-auto text-xs tracking-widest text-zinc-400 dark:text-zinc-500',
    ])->merge([
        'data-dropdown-menu-shortcut' => true,
    ])
}}>
    {{ $slot }}
</span>
