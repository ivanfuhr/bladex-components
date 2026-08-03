@props([
    'mode' => 'single',
    'months' => null,
    'value' => null,
    'name' => null,
    'min' => null,
    'max' => null,
    'unavailable' => null,
    'startDay' => null,
    'locale' => null,
    'timezone' => null,
    'weekNumbers' => false,
    'selectableHeader' => false,
    'withToday' => false,
    'fixedWeeks' => false,
    'openTo' => null,
    'forceOpenTo' => false,
    'size' => 'default',
    'minRange' => null,
    'maxRange' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Date\DateFormatter;

    $range = $mode === 'range';
    $monthCount = (int) ($months ?? ($range ? 2 : 1));
    $resolvedTimezone = DateFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = DateFormatter::normalizeDateValue($value, $mode);

    if (is_array($unavailable)) {
        $unavailable = collect($unavailable)->implode(',');
    }

    $sizeClasses = match ($size) {
        'sm' => 'size-9 text-sm',
        'lg' => 'size-11 text-sm',
        'xl' => 'size-12 text-sm',
        '2xl' => 'size-12 sm:size-14 text-sm',
        default => 'size-10 text-sm',
    };
@endphp

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
                    class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
                    data-calendar-today
                    aria-label="{{ __('stencil::messages.preset_today') }}"
                >
                    <span class="text-xs font-semibold" data-calendar-today-label></span>
                </button>
            @endif
            <button
                type="button"
                class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
                data-calendar-prev
                aria-label="{{ __('stencil::messages.calendar_previous_month') }}"
            >
                <x-stencil::icon name="chevron-left" class="size-4" />
            </button>
            <button
                type="button"
                class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
                data-calendar-next
                aria-label="{{ __('stencil::messages.calendar_next_month') }}"
            >
                <x-stencil::icon name="chevron-right" class="size-4" />
            </button>
        </div>
    </div>

    <div class="flex gap-4" data-calendar-months-container></div>
</div>
