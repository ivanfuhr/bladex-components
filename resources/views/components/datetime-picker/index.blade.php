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
    'shortcut' => true,
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
@endphp

<div
    {{ $attributes->except(['shortcut'])->class(['datetime-picker relative min-w-0', 'w-full' => ! filled($attributes->get('class'))]) }}
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

    @if ($shortcut)
        <x-stencil::date-picker.button
            :placeholder="$resolvedPlaceholder"
            :$invalid
            :$disabled
            :$clearable
            :$size
            data-datetime-picker-trigger
        />

        <x-stencil::datetime-picker.panel>
            <div class="grid gap-0 md:grid-cols-[1fr_11rem]">
                <x-stencil::calendar
                    :value="$datePart"
                    :timezone="$resolvedTimezone"
                    :locale="$resolvedLocale"
                    :with-today="$withToday"
                    data-datetime-picker-calendar
                />

                <x-stencil::datetime-picker.time-list />
            </div>

            <x-stencil::datetime-picker.footer />
        </x-stencil::datetime-picker.panel>
    @else
        {{ $slot }}
    @endif
</div>
