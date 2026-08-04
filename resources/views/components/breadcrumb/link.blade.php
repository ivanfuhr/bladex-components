<a {{
    $attributes->class([
        'breadcrumb__link',
        'inline-flex min-h-11 items-center rounded-md px-1 transition-colors hover:text-zinc-950 dark:hover:text-zinc-50',
    ])->merge([
        'href' => $href,
        'data-breadcrumb-link' => true,
    ])
}}>
    {{ $slot }}
</a>
