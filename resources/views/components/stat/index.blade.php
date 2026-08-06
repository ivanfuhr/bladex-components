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
                    <x-std::stat.label>{{ $label }}</x-std::stat.label>
                @endif
                @if (filled($value) || $value === 0 || $value === 0.0 || $value === '0')
                    <x-std::stat.value>{{ $value }}</x-std::stat.value>
                @endif
            </div>
            @if (filled($icon))
                <x-std::stat.icon>
                    <x-std::icon :name="$icon" class="size-4" />
                </x-std::stat.icon>
            @endif
        </div>
        @if (filled($description) || filled($trend))
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                @if (filled($trend))
                    <x-std::stat.trend :direction="$trendDirection">{{ $trend }}</x-std::stat.trend>
                @endif
                @if (filled($description))
                    <x-std::stat.description>{{ $description }}</x-std::stat.description>
                @endif
            </div>
        @endif
    @endif
</div>
