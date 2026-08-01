@props([
    'variant' => 'default',
    'title' => null,
    'description' => null,
    'duration' => 4000,
    'open' => true,
])

@php
    $variantClasses = match ($variant) {
        'success' => 'border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950 dark:text-green-50',
        'danger', 'destructive', 'error' => 'border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950 dark:text-red-50',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-50',
        default => 'border-zinc-200 bg-white text-zinc-950 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
    };
@endphp

<div {{
    $attributes->class([
        'toast',
        'pointer-events-auto relative w-full rounded-xl border p-4 shadow-lg',
        $variantClasses,
        ! $open ? 'hidden' : null,
    ])->merge([
        'data-toast' => true,
        'data-variant' => $variant,
        'data-duration' => (string) $duration,
        'data-state' => $open ? 'open' : 'closed',
        'role' => 'status',
        'hidden' => $open ? null : true,
    ])
}}>
    <div class="flex items-start gap-3 pr-6">
        <div class="min-w-0 flex-1 space-y-1">
            @if (filled($title))
                <x-stencil::toast.title>{{ $title }}</x-stencil::toast.title>
            @endif
            @if (filled($description))
                <x-stencil::toast.description>{{ $description }}</x-stencil::toast.description>
            @endif
            {{ $slot }}
        </div>
    </div>
    <x-stencil::toast.close />
</div>
