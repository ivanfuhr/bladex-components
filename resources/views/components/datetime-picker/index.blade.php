@props([
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'size' => null,
    'timezone' => null,
    'locale' => null,
    'withSeconds' => false,
    'timeStep' => 30,
    'withToday' => false,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Chrono\ChronoFormatter;

    $invalid = $invalid || $fieldInvalid;
    $resolvedTimezone = ChronoFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = ChronoFormatter::normalizeDateTimeValue($value, $resolvedTimezone);
    $resolvedPlaceholder = $placeholder ?? __('stencil::messages.datetime_picker_placeholder');

    $datePart = $resolvedValue ? explode('T', $resolvedValue)[0] ?? '' : '';
    $timePart = null;

    if ($resolvedValue && str_contains($resolvedValue, 'T')) {
        $timePart = substr($resolvedValue, strpos($resolvedValue, 'T') + 1, 8);
    }
@endphp

<div
    {{ $attributes->class(['datetime-picker relative min-w-0', 'w-full' => ! filled($attributes->get('class'))]) }}
    data-datetime-picker
    data-datetime-picker-timezone="{{ $resolvedTimezone }}"
    data-datetime-picker-locale="{{ $resolvedLocale }}"
    @if ($withSeconds) data-datetime-picker-seconds @endif
>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $resolvedValue }}" data-datetime-picker-hidden-input />
    @else
        <input type="hidden" value="{{ $resolvedValue }}" data-datetime-picker-hidden-input />
    @endif

    <x-stencil::date-picker.button
        :placeholder="$resolvedPlaceholder"
        :$invalid
        :$disabled
        :$clearable
        :$size
        data-datetime-picker-trigger
    />

    <div
        class="datetime-picker__panel z-50 max-w-[calc(100vw-2rem)] rounded-xl border border-zinc-200 bg-white p-0 shadow-xl dark:border-zinc-800 dark:bg-zinc-950"
        data-datetime-picker-panel
        hidden
        aria-hidden="true"
    >
        <div class="grid gap-0 md:grid-cols-[1fr_11rem]">
            <x-stencil::calendar
                :value="$datePart"
                :timezone="$resolvedTimezone"
                :locale="$resolvedLocale"
                :with-today="$withToday"
                data-datetime-picker-calendar
            />

            <div
                class="max-h-80 overflow-y-auto border-t border-zinc-200 p-1 md:border-s md:border-t-0 dark:border-zinc-800"
                data-datetime-picker-time-list
            ></div>
        </div>

        <div class="flex justify-end gap-2 border-t border-zinc-200 p-3 dark:border-zinc-800">
            <x-stencil::button type="button" variant="ghost" data-datetime-picker-cancel>
                {{ __('stencil::messages.date_picker_cancel') }}
            </x-stencil::button>
            <x-stencil::button type="button" variant="primary" data-datetime-picker-confirm>
                {{ __('stencil::messages.date_picker_select_date') }}
            </x-stencil::button>
        </div>
    </div>
</div>
