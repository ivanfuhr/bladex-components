<div
    {{
        $attributes->class([
            'skeleton',
            'animate-pulse bg-zinc-200 dark:bg-zinc-800',
            $radius,
        ])->merge([
            'data-skeleton' => true,
            'aria-hidden' => 'true',
        ])
    }}
></div>
