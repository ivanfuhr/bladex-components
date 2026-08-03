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
    use Ivanfuhr\Stencil\Support\Date\DateFormatter;

    $invalid = $invalid || $fieldInvalid;
    $resolvedTimezone = DateFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = DateFormatter::normalizeDateTimeValue($value, $resolvedTimezone);
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
            {{-- Absolute time column on md+ so list height tracks the calendar (no dead space). --}}
            <div class="relative flex flex-col md:flex-row">
                <div class="shrink-0 p-4">
                    <x-stencil::calendar
                        :value="$datePart"
                        :timezone="$resolvedTimezone"
                        :locale="$resolvedLocale"
                        :with-today="$withToday"
                        class="w-fit"
                        data-datetime-picker-calendar
                    />
                </div>

                <div class="hidden w-40 shrink-0 md:block" aria-hidden="true"></div>

                <x-stencil::datetime-picker.time-list />
            </div>

            <x-stencil::datetime-picker.footer />
        </x-stencil::datetime-picker.panel>
    @else
        {{ $slot }}
    @endif
</div>
