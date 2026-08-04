<div {{
    $attributes->class([
        'dropdown-menu__content',
        'z-50 min-w-40 overflow-hidden rounded-lg border border-zinc-200 bg-white p-1 text-zinc-950 shadow-lg',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        'hidden data-[state=open]:block',
    ])->merge([
        'data-dropdown-menu-content' => true,
        'data-state' => 'closed',
        'data-align' => $align,
        'data-side' => $side,
        'data-keep-open' => $keepOpen ? 'true' : null,
        'role' => 'menu',
        'aria-orientation' => 'vertical',
        'tabindex' => '-1',
        'hidden' => true,
        'inert' => true,
        'aria-hidden' => 'true',
    ])
}}>
    {{ $slot }}
</div>
