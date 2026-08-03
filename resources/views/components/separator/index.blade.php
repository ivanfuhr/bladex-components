<div
    {{
        $attributes->class([
            'separator',
            'shrink-0 bg-zinc-200 dark:bg-zinc-800',
            $isVertical ? 'mx-2 h-full w-px' : 'my-2 h-px w-full',
        ])->merge([
            'data-separator' => true,
            'data-orientation' => $isVertical ? 'vertical' : 'horizontal',
            'role' => $decorative ? 'none' : 'separator',
            'aria-orientation' => $decorative ? null : ($isVertical ? 'vertical' : 'horizontal'),
        ])
    }}
></div>
