<div {{
    $attributes->class([
        'stat__label',
        'text-sm font-medium text-zinc-500 dark:text-zinc-400',
    ])->merge([
        'data-stat-label' => true,
    ])
}}>
    {{ $slot }}
</div>
