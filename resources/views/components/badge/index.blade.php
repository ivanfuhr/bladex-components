<{{ $tag }}
    {{
        $attributes->class([
            ...$baseClasses,
            $variantClasses,
            $useLink || $as === 'button'
            ? 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20'
            : null,
        ])->merge([
            'data-badge' => true,
            'data-variant' => $variant,
            'href' => $useLink ? ($href ?? '#') : null,
            'type' => $as === 'button' ? 'button' : null,
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
