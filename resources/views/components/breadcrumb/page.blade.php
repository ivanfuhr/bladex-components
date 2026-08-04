<span {{
    $attributes->class([
        'breadcrumb__page',
        'font-normal text-zinc-950 dark:text-zinc-50',
    ])->merge([
        'aria-current' => 'page',
        'data-breadcrumb-page' => true,
    ])
}}>
    {{ $slot }}
</span>
