<span {{
    $attributes->class([
        'breadcrumb__page',
        'font-normal text-zinc-950 dark:text-zinc-50',
    ])->merge([
        'role' => 'link',
        'aria-disabled' => 'true',
        'aria-current' => 'page',
        'data-breadcrumb-page' => true,
    ])
}}>
    {{ $slot }}
</span>
