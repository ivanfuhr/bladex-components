@props([
    'variant' => 'secondary',
    'color' => null,
    'size' => null,
    'rounded' => false,
    'href' => null,
    'as' => null,
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'px-1.5 py-0 text-[10px]',
        'lg' => 'px-2.5 py-1 text-sm',
        default => 'px-2 py-0.5 text-xs',
    };

    $baseClasses = [
        'badge',
        'inline-flex items-center gap-1 font-medium whitespace-nowrap',
        $rounded ? 'rounded-full' : 'rounded-md',
        $sizeClasses,
    ];

    $variantClasses = match (true) {
        filled($color) && $variant === 'solid' => match ($color) {
            'red' => 'bg-red-600 text-white',
            'orange' => 'bg-orange-600 text-white',
            'amber' => 'bg-amber-500 text-zinc-950',
            'green' => 'bg-green-600 text-white',
            'blue' => 'bg-blue-600 text-white',
            'indigo' => 'bg-indigo-600 text-white',
            'violet' => 'bg-violet-600 text-white',
            'rose' => 'bg-rose-600 text-white',
            'lime' => 'bg-lime-500 text-zinc-950',
            default => 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900',
        },
        filled($color) => match ($color) {
            'red' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
            'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-300',
            'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
            'green' => 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300',
            'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
            'indigo' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
            'violet' => 'bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
            'rose' => 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
            'lime' => 'bg-lime-100 text-lime-800 dark:bg-lime-950 dark:text-lime-300',
            default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
        },
        $variant === 'default' || $variant === 'primary' => 'bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900',
        $variant === 'destructive' || $variant === 'danger' => 'bg-red-600 text-white',
        $variant === 'outline' => 'border border-zinc-200 bg-transparent text-zinc-700 dark:border-zinc-700 dark:text-zinc-200',
        $variant === 'ghost' => 'bg-transparent text-zinc-600 dark:text-zinc-300',
        $variant === 'solid' => 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900',
        default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
    };

    $useLink = filled($href) || $as === 'a';
    $tag = $useLink ? 'a' : ($as === 'button' ? 'button' : 'span');
@endphp

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
