<p {{
    $attributes->class([
        'empty__description',
        'text-sm leading-relaxed text-zinc-500 dark:text-zinc-400',
        '[&>a]:underline [&>a]:underline-offset-4 [&>a:hover]:text-zinc-950 dark:[&>a:hover]:text-zinc-50',
    ])->merge([
        'data-empty-description' => true,
    ])
}}>
    {{ $slot }}
</p>
