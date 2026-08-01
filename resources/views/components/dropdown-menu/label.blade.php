<div {{
    $attributes->class([
        'dropdown-menu__label',
        'px-2 py-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400',
    ])->merge([
        'data-dropdown-menu-label' => true,
    ])
}}>
    {{ $slot }}
</div>
