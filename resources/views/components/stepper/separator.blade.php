<div
    {{
        $attributes->class([
            'stepper__separator',
            'bg-zinc-200 dark:bg-zinc-800',
            'group-data-[state=completed]/step:bg-zinc-900 dark:group-data-[state=completed]/step:bg-zinc-100',
            $isVertical
                ? 'ms-4 mt-2 hidden h-6 w-px group-[:not(:last-child)]/step:block'
                : 'hidden',
        ])->merge([
            'data-stepper-separator' => true,
            'aria-hidden' => 'true',
            'role' => 'none',
        ])
    }}
></div>
