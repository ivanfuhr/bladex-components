<div {{
    $attributes->class([
        'stat__description',
        'text-xs text-zinc-500 dark:text-zinc-400',
    ])->merge([
        'data-stat-description' => true,
    ])
}}>{{ $slot }}</div>
