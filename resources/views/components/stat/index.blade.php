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
                    <x-ui::stat.label>{{ $label }}</x-ui::stat.label>
                @endif
                @if (filled($value) || $value === 0 || $value === 0.0 || $value === '0')
                    <x-ui::stat.value>{{ $value }}</x-ui::stat.value>
                @endif
            </div>
            @if (filled($icon))
                <x-ui::stat.icon>
                    <x-ui::icon :name="$icon" class="size-4" />
                </x-ui::stat.icon>
            @endif
        </div>
        @if (filled($description) || filled($trend))
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                @if (filled($trend))
                    <x-ui::stat.trend :direction="$trendDirection">{{ $trend }}</x-ui::stat.trend>
                @endif
                @if (filled($description))
                    <x-ui::stat.description>{{ $description }}</x-ui::stat.description>
                @endif
            </div>
        @endif
    @endif
</div>
