<div
    {{ $attributes->class([
        'bladex-input-group__suffix',
        'inline-flex shrink-0 items-center rounded-r-md border border-l-0 border-zinc-200 bg-zinc-50 px-3 text-sm text-zinc-600',
        'dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400',
    ]) }}
    data-bladex-input-group-suffix
>
    {{ $slot }}
</div>
