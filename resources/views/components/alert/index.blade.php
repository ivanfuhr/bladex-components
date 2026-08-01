@props([
    'variant' => 'default',
    'title' => null,
    'icon' => null,
])

@php
    $variantClasses = match ($variant) {
        'success' => 'border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950/40 dark:text-green-50',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-50',
        'danger', 'destructive', 'error' => 'border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950/40 dark:text-red-50',
        'info' => 'border-sky-200 bg-sky-50 text-sky-950 dark:border-sky-900 dark:bg-sky-950/40 dark:text-sky-50',
        default => 'border-zinc-200 bg-zinc-50 text-zinc-950 dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-50',
    };
@endphp

<div {{
    $attributes->class([
        'alert',
        'relative w-full rounded-xl border px-4 py-3 text-sm',
        $variantClasses,
    ])->merge([
        'role' => 'alert',
        'data-alert' => true,
        'data-variant' => $variant,
    ])
}}>
    <div class="flex gap-3">
        @if (filled($icon))
            <span class="mt-0.5 inline-flex shrink-0" data-alert-icon aria-hidden="true">
                <x-stencil::icon :name="$icon" class="size-4" />
            </span>
        @endif
        <div class="min-w-0 flex-1 space-y-1">
            @if (filled($title))
                <x-stencil::alert.title>{{ $title }}</x-stencil::alert.title>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
