@aware([
    'orientation' => 'horizontal',
])

@php
    $isVertical = $orientation === 'vertical';
@endphp

<div {{
    $attributes->class([
        'stepper__separator',
        'bg-zinc-200 dark:bg-zinc-800',
        'group-data-[state=completed]/step:bg-zinc-900 dark:group-data-[state=completed]/step:bg-zinc-100',
        $isVertical
            ? 'ms-4 mt-2 hidden h-6 w-px group-[:not(:last-child)]/step:block'
            : 'absolute start-[calc(50%+1.25rem)] top-4 hidden h-px w-[calc(100%-2.5rem)] group-[:not(:last-child)]/step:block',
    ])->merge([
        'data-stepper-separator' => true,
        'aria-hidden' => 'true',
        'role' => 'none',
    ])
}}></div>
