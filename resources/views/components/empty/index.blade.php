<div {{
    $attributes->class([
        'empty',
        'flex min-w-0 flex-1 flex-col items-center justify-center gap-6 rounded-xl border border-dashed border-zinc-200 p-6 text-center text-balance md:p-12 dark:border-zinc-800',
    ])->merge([
        'data-empty' => true,
        'role' => 'status',
    ])
}}>
    {{ $slot }}
</div>
