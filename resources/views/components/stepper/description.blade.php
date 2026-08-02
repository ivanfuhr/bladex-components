<span
    {{
        $attributes->class([
            'stepper__description',
            'block text-xs text-zinc-500 dark:text-zinc-400',
        ])->merge([
            'data-stepper-description' => true,
        ])
    }}
>{{ $slot }}</span>
