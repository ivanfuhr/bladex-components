<span {{
    $attributes->class([
        'tooltip__content',
        'pointer-events-none z-50 w-max max-w-xs whitespace-nowrap rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-zinc-50 shadow-md',
        'dark:bg-zinc-100 dark:text-zinc-900',
        'hidden data-[state=open]:block',
    ])->merge([
        'role' => 'tooltip',
        'data-tooltip-content' => true,
        'data-side' => $resolvedSide,
        'data-state' => 'closed',
        'hidden' => true,
    ])
}}>
    {{ $slot }}
</span>
