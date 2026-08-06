<div
    {{ $attributes->class(['calendar w-full']) }}
    data-calendar
    tabindex="-1"
    data-calendar-mode="{{ $mode }}"
    data-calendar-month-count="{{ $monthCount }}"
    @if (filled($resolvedValue)) data-calendar-value="{{ $resolvedValue }}" @endif
    @if (filled($name)) data-calendar-name="{{ $name }}" @endif
    @if (filled($min)) data-calendar-min="{{ $min }}" @endif
    @if (filled($max)) data-calendar-max="{{ $max }}" @endif
    @if (filled($unavailable)) data-calendar-unavailable="{{ $unavailable }}" @endif
    @if (filled($startDay)) data-calendar-start-day="{{ $startDay }}" @endif
    data-calendar-locale="{{ $resolvedLocale }}"
    data-calendar-timezone="{{ $resolvedTimezone }}"
    @if ($weekNumbers) data-calendar-week-numbers @endif
    @if ($selectableHeader) data-calendar-selectable-header @endif
    @if ($withToday) data-calendar-with-today @endif
    @if ($fixedWeeks) data-calendar-fixed-weeks @endif
    @if (filled($openTo)) data-calendar-open-to="{{ $openTo }}" @endif
    @if ($forceOpenTo) data-calendar-force-open-to @endif
    @if (filled($minRange)) data-calendar-min-range="{{ $minRange }}" @endif
    @if (filled($maxRange)) data-calendar-max-range="{{ $maxRange }}" @endif
    data-calendar-size-class="{{ $sizeClasses }}"
>
    <div class="mb-2 flex items-center justify-between gap-2" data-calendar-header>
        <span
            class="min-w-0 truncate text-sm font-medium text-zinc-800 dark:text-zinc-50"
            data-calendar-month-label
        ></span>
        <div class="flex shrink-0 items-center gap-0.5">
            @if ($withToday)
                <button
                    type="button"
                    class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                    data-calendar-today
                    aria-label="{{ __('Today') }}"
                >
                    <span class="text-xs font-semibold" data-calendar-today-label></span>
                </button>
            @endif
            <button
                type="button"
                class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                data-calendar-prev
                aria-label="{{ __('Previous month') }}"
            >
                <x-std::icon name="chevron-left" class="size-4" />
            </button>
            <button
                type="button"
                class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                data-calendar-next
                aria-label="{{ __('Next month') }}"
            >
                <x-std::icon name="chevron-right" class="size-4" />
            </button>
        </div>
    </div>

    <div class="flex gap-4" data-calendar-months-container></div>
</div>
