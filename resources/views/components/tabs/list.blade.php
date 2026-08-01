@aware([
    'orientation' => 'horizontal',
    'variant' => 'default',
])

@php
    $listClasses = match ($variant) {
        'segmented' => 'inline-flex items-center gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800',
        'pills' => 'inline-flex items-center gap-2',
        'line' => 'inline-flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-800',
        default => 'inline-flex items-center gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800',
    };
@endphp

<div {{
    $attributes->class([
        'tabs__list',
        $listClasses,
        $orientation === 'vertical' ? 'flex-col' : null,
    ])->merge([
        'role' => 'tablist',
        'aria-orientation' => $orientation,
        'data-tabs-list' => true,
    ])
}}>
    {{ $slot }}
</div>
