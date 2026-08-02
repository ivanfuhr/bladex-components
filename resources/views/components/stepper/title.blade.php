<span
    {{
        $attributes->class([
            'stepper__title',
            'text-sm font-medium text-zinc-950 dark:text-zinc-50',
            'group-data-[state=inactive]/step:text-zinc-600 dark:group-data-[state=inactive]/step:text-zinc-400',
        ])->merge([
            'data-stepper-title' => true,
        ])
    }}
>{{ $slot }}</span>
