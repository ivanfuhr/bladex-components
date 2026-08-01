<span {{
    $attributes->class([
        'breadcrumb__ellipsis',
        'flex size-9 items-center justify-center',
    ])->merge([
        'role' => 'presentation',
        'aria-hidden' => 'true',
        'data-breadcrumb-ellipsis' => true,
    ])
}}>
    <span class="text-zinc-500 dark:text-zinc-400">…</span>
    <span class="sr-only">{{ __('stencil::messages.breadcrumb_ellipsis') }}</span>
</span>
