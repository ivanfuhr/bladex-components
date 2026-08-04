<span {{
    $attributes->class([
        'pagination__ellipsis',
        'flex size-9 items-center justify-center',
    ])->merge([
        'aria-hidden' => 'true',
        'data-pagination-ellipsis' => true,
    ])
}}>
    <span class="text-zinc-500 dark:text-zinc-400">…</span>
    <span class="sr-only">{{ __('More pages') }}</span>
</span>
