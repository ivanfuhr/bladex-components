<{{ $tag }}
    {{
        $attributes->class([
            'pagination__link',
            'inline-flex size-11 items-center justify-center rounded-md text-sm font-medium transition-colors',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
            $isActive
            ? 'border border-zinc-200 bg-white text-zinc-950 shadow-sm dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-50'
            : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            $isDisabled ? 'pointer-events-none opacity-50' : null,
        ])->merge([
            'href' => $isDisabled ? null : $href,
            'aria-current' => $isActive ? 'page' : null,
            'aria-disabled' => $isDisabled ? 'true' : null,
            'data-pagination-link' => true,
            'data-active' => $isActive ? 'true' : null,
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
