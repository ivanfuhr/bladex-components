<div {{
    $attributes->class([
        'card',
        'flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white text-zinc-950 shadow-sm',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        $padding,
    ])->merge([
        'data-card' => true,
        'data-size' => $size,
    ])
}}>
    {{ $slot }}
</div>
