@props([
    'open' => false,
])

<div
    {{
        $attributes->class([
            'popover',
            'fixed z-50 rounded-lg border border-zinc-200 bg-white p-4 shadow-lg',
            'dark:border-zinc-800 dark:bg-zinc-950',
            'hidden data-[state=open]:block',
        ])
    }}
    data-popover
    data-state="{{ $open ? 'open' : 'closed' }}"
    tabindex="-1"
>
    {{ $slot }}
</div>
