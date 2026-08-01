@props([])

<div {{
    $attributes->class([
        'button-group__text',
        'flex items-center gap-2 rounded-md border border-zinc-200 bg-zinc-100 px-4 text-sm font-medium shadow-sm',
        'dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-50',
        '[&_svg]:pointer-events-none [&_svg:not([class*=size-])]:size-4',
    ])->merge([
        'data-button-group-text' => true,
    ])
}}>
    {{ $slot }}
</div>
