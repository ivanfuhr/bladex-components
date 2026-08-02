<div {{
    $attributes->class([
        'stat__value',
        'text-2xl font-semibold tracking-tight text-zinc-950 tabular-nums dark:text-zinc-50',
    ])->merge([
        'data-stat-value' => true,
    ])
}}>
    {{ $slot }}
</div>
