<p {{
    $attributes->class([
        'card__description',
        'text-sm text-zinc-500 dark:text-zinc-400',
    ])->merge([
        'data-card-description' => true,
    ])
}}>
    {{ $slot }}
</p>
