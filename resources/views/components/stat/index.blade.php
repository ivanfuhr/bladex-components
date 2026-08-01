@props([
    'label' => null,
    'value' => null,
    'description' => null,
    'trend' => null,
    'trendDirection' => null,
    'icon' => null,
    'variant' => 'default',
])

@php
    $variantClasses = match ($variant) {
        'outline' => 'border border-zinc-200 bg-transparent shadow-none dark:border-zinc-800',
        'muted' => 'border border-transparent bg-zinc-100 shadow-none dark:bg-zinc-900',
        default => 'border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950',
    };
@endphp

<div {{
    $attributes->class([
        'stat',
        'relative flex flex-col gap-3 rounded-xl p-5 text-zinc-950 dark:text-zinc-50',
        $variantClasses,
    ])->merge([
        'data-stat' => true,
        'data-variant' => $variant,
        'data-trend-direction' => filled($trendDirection) ? (string) $trendDirection : null,
    ])
}}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0 space-y-1">
                @if (filled($label))
                    <x-stencil::stat.label>{{ $label }}</x-stencil::stat.label>
                @endif
                @if (filled($value) || $value === 0 || $value === 0.0 || $value === '0')
                    <x-stencil::stat.value>{{ $value }}</x-stencil::stat.value>
                @endif
            </div>
            @if (filled($icon))
                <x-stencil::stat.icon>
                    <x-stencil::icon :name="$icon" class="size-4" />
                </x-stencil::stat.icon>
            @endif
        </div>
        @if (filled($description) || filled($trend))
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                @if (filled($trend))
                    <x-stencil::stat.trend :direction="$trendDirection">{{ $trend }}</x-stencil::stat.trend>
                @endif
                @if (filled($description))
                    <x-stencil::stat.description>{{ $description }}</x-stencil::stat.description>
                @endif
            </div>
        @endif
    @endif
</div>
