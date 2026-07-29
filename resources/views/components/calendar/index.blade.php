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
    use Ivanfuhr\Stencil\Support\Chrono\ChronoFormatter;

    $range = $mode === 'range';
    $monthCount = (int) ($months ?? ($range ? 2 : 1));
    $resolvedTimezone = ChronoFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = ChronoFormatter::normalizeDateValue($value, $mode);

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
    {{ $attributes->class(['calendar isolate relative']) }}
    data-calendar
    data-calendar-mode="{{ $mode }}"
    data-calendar-months="{{ $monthCount }}"
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
    <div class="relative" data-calendar-chrome>
        <div class="absolute inset-x-0 top-0 z-10 p-2" data-calendar-header>
            <header class="flex items-center justify-between">
                <div class="flex items-center gap-2" data-calendar-header-labels>
                    <span class="text-sm font-medium text-zinc-800 dark:text-zinc-50" data-calendar-month-label></span>
                </div>
                <div class="flex items-center gap-1">
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
                        aria-label="Previous month"
                    >
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                    </button>
                    <button
                        type="button"
                        class="inline-flex size-8 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
                        data-calendar-next
                        aria-label="Next month"
                    >
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            </header>
        </div>
    </div>

    <div class="flex justify-center gap-4 p-2 pt-12" data-calendar-months></div>
</div>
