<div
    {{
        $attributes->class([
            'input-group__suffix',
            'inline-flex shrink-0 items-center rounded-r-md border border-l-0 border-zinc-200 bg-zinc-50 px-3',
            'dark:border-zinc-800 dark:bg-zinc-900',
        ])
    }}
    data-input-group-suffix
>
    <x-std::text inline size="sm" variant="subtle">{{ $slot }}</x-std::text>
</div>
