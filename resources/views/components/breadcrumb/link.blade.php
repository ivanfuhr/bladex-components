@props([
    'href' => '#',
])

<a {{
    $attributes->class([
        'breadcrumb__link',
        'transition-colors hover:text-zinc-950 dark:hover:text-zinc-50',
    ])->merge([
        'href' => $href,
        'data-breadcrumb-link' => true,
    ])
}}>
    {{ $slot }}
</a>
