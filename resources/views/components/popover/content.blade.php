<div {{
    $attributes->class([
        'popover__content',
        'z-50 rounded-lg border border-zinc-200 bg-white p-4 text-zinc-950 shadow-lg',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        'hidden data-[state=open]:block',
    ])->merge([
        'data-popover-content' => true,
        'data-state' => $open ? 'open' : 'closed',
        'data-align' => $align,
        'data-side' => $side,
        'role' => 'dialog',
        'aria-modal' => 'false',
        'tabindex' => '-1',
        'hidden' => $open ? null : true,
        'inert' => $open ? null : true,
        'aria-hidden' => $open ? null : 'true',
    ])
}}>
    {{ $slot }}
</div>
