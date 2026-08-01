<ol {{
    $attributes->class([
        'breadcrumb__list',
        'flex flex-wrap items-center gap-1.5 text-sm text-zinc-500 break-words sm:gap-2.5 dark:text-zinc-400',
    ])->merge([
        'data-breadcrumb-list' => true,
    ])
}}>
    {{ $slot }}
</ol>
