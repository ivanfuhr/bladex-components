<div
    {{
        $attributes->class([
            'input-group__prefix',
            'inline-flex shrink-0 items-center rounded-l-md border border-r-0 border-zinc-200 bg-zinc-50 px-3',
            'dark:border-zinc-800 dark:bg-zinc-900',
        ])
    }}
    data-input-group-prefix
>
    <x-ui::text inline size="sm" variant="subtle">{{ $slot }}</x-ui::text>
</div>
