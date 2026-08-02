<span
    {{
        $attributes->class([
            'stat__icon',
            'inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600',
            'dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300',
        ])->merge([
            'data-stat-icon' => true,
            'aria-hidden' => 'true',
        ])
    }}
>{{ $slot }}</span>
