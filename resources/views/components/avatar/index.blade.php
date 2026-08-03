<{{ $tag }}
    {{
        $attributes->class([
            'avatar',
            'relative inline-flex shrink-0 items-center justify-center overflow-hidden font-medium select-none',
            $sizeClasses,
            $shapeClass,
            $colorClasses,
            $useLink || $as === 'button'
            ? 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20'
            : null,
        ])->merge([
            'data-avatar' => true,
            'data-size' => $size,
            'href' => $useLink ? ($href ?? '#') : null,
            'type' => $as === 'button' ? 'button' : null,
        ])
    }}
>
    @if (filled($src))
        <x-ui::avatar.image :src="$src" :alt="$resolvedAlt" />
        <x-ui::avatar.fallback>
            {{ $resolvedInitials ?? mb_strtoupper(mb_substr((string) $resolvedAlt, 0, 1)) }}</x-ui::avatar.fallback>
    @elseif (! $slot->isEmpty())
        {{ $slot }}
    @elseif (filled($resolvedInitials))
        <x-ui::avatar.fallback>{{ $resolvedInitials }}</x-ui::avatar.fallback>
    @else
        {{ $slot }}
    @endif
</{{ $tag }}>
