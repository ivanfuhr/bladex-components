@props([
    'src' => null,
    'alt' => null,
    'name' => null,
    'initials' => null,
    'size' => 'md',
    'circle' => false,
    'color' => null,
    'href' => null,
    'as' => null,
])

@php
    $sizeClasses = match ($size) {
        'xs' => 'size-6 text-[10px]',
        'sm' => 'size-8 text-xs',
        'lg' => 'size-12 text-base',
        'xl' => 'size-16 text-lg',
        default => 'size-10 text-sm',
    };

    if (filled($initials)) {
        $resolvedInitials = (string) $initials;
    } elseif (filled($name)) {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $resolvedInitials = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        if ($resolvedInitials === '' && filled($name)) {
            $resolvedInitials = mb_strtoupper(mb_substr((string) $name, 0, 2));
        }
    } else {
        $resolvedInitials = null;
    }

    $resolvedAlt = $alt ?? $name ?? 'Avatar';

    $palette = [
        'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
        'bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-300',
        'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
        'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300',
        'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
        'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
        'bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
        'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
    ];

    $colorClasses = match ($color) {
        'red' => $palette[0],
        'orange' => $palette[1],
        'amber' => $palette[2],
        'green' => $palette[3],
        'blue' => $palette[4],
        'indigo' => $palette[5],
        'violet' => $palette[6],
        'rose' => $palette[7],
        'auto' => $palette[crc32(filled($name) ? (string) $name : (string) ($resolvedInitials ?? 'A')) % count($palette)],
        default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
    };

    $shapeClass = $circle ? 'rounded-full' : 'rounded-lg';
    $useLink = filled($href) || $as === 'a';
    $tag = $useLink ? 'a' : ($as === 'button' ? 'button' : 'span');
@endphp

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
        <x-stencil::avatar.image :src="$src" :alt="$resolvedAlt" />
        <x-stencil::avatar.fallback>
            {{ $resolvedInitials ?? mb_strtoupper(mb_substr((string) $resolvedAlt, 0, 1)) }}</x-stencil::avatar.fallback>
    @elseif (! $slot->isEmpty())
        {{ $slot }}
    @elseif (filled($resolvedInitials))
        <x-stencil::avatar.fallback>{{ $resolvedInitials }}</x-stencil::avatar.fallback>
    @else
        {{ $slot }}
    @endif
</{{ $tag }}>
