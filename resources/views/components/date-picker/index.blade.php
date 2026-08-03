@props([
    'name' => null,
    'value' => null,
    'mode' => 'single',
    'type' => 'button',
    'placeholder' => null,
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'locale' => null,
    'timezone' => null,
    'months' => null,
    'min' => null,
    'max' => null,
    'unavailable' => null,
    'startDay' => null,
    'weekNumbers' => false,
    'selectableHeader' => false,
    'withToday' => false,
    'fixedWeeks' => false,
    'openTo' => null,
    'forceOpenTo' => false,
    'withConfirmation' => false,
    'withInputs' => false,
    'withPresets' => false,
    'presets' => null,
    'minRange' => null,
    'maxRange' => null,
    'shortcut' => true,
    'allTimeStart' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Date\DateFormatter;
    use Ivanfuhr\Stencil\Support\Date\DateRangePreset;

    $invalid = $invalid || $fieldInvalid;
    $range = $mode === 'range';
    $resolvedTimezone = DateFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = DateFormatter::normalizeDateValue($value, $mode);
    $resolvedPlaceholder = $placeholder ?? ($range
        ? __('stencil::messages.date_picker_range_placeholder')
        : __('stencil::messages.date_picker_placeholder'));
    $monthCount = (int) ($months ?? ($range ? 2 : 1));

    $presetKeys = $withPresets
        ? ($presets ?? 'today yesterday thisWeek last7Days thisMonth yearToDate allTime custom')
        : null;

    $presetMeta = $presetKeys
        ? DateRangePreset::metadataForKeys(
            $presetKeys,
            filled($allTimeStart) ? \Illuminate\Support\Carbon::parse($allTimeStart) : null,
        )
        : [];
@endphp

<div
    {{
        $attributes->except(['shortcut'])->class([
            'date-picker relative min-w-0',
            'w-full' => ! filled($attributes->get('class')),
        ])
    }}
    data-date-picker
    @if ($withConfirmation) data-date-picker-with-confirmation @endif
    data-date-picker-mode="{{ $mode }}"
    data-date-picker-locale="{{ $resolvedLocale }}"
    data-date-picker-timezone="{{ $resolvedTimezone }}"
    @if ($presetMeta !== []) data-date-picker-presets="{{ e(json_encode($presetMeta)) }}" @endif
>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $resolvedValue }}" data-date-picker-hidden-input />
    @else
        <input type="hidden" value="{{ $resolvedValue }}" data-date-picker-hidden-input />
    @endif

    @if ($shortcut)
        @if (isset($trigger))
            {{ $trigger }}
        @elseif ($type === 'input')
            <x-stencil::date-picker.input :$placeholder :$invalid :$disabled :$clearable :$size />
        @else
            <x-stencil::date-picker.button :$placeholder :$invalid :$disabled :$clearable :$size />
        @endif

        <x-stencil::date-picker.panel :$range>
            @if ($withPresets && $presetMeta !== [])
                <x-stencil::date-picker.presets :preset-meta="$presetMeta">
                    @if ($withInputs)
                        <x-stencil::date-picker.manual-inputs />
                    @endif

                    <x-stencil::calendar
                        :mode="$mode"
                        :months="$monthCount"
                        :value="$resolvedValue"
                        :min="$min"
                        :max="$max"
                        :unavailable="$unavailable"
                        :start-day="$startDay"
                        :locale="$resolvedLocale"
                        :timezone="$resolvedTimezone"
                        :week-numbers="$weekNumbers"
                        :selectable-header="$selectableHeader"
                        :with-today="$withToday"
                        :fixed-weeks="$fixedWeeks"
                        :open-to="$openTo"
                        :force-open-to="$forceOpenTo"
                        :size="$size ?? 'default'"
                        :min-range="$minRange"
                        :max-range="$maxRange"
                    />
                </x-stencil::date-picker.presets>
            @else
                <div class="min-w-0">
                    @if ($withInputs)
                        <x-stencil::date-picker.manual-inputs />
                    @endif

                    <x-stencil::calendar
                        :mode="$mode"
                        :months="$monthCount"
                        :value="$resolvedValue"
                        :min="$min"
                        :max="$max"
                        :unavailable="$unavailable"
                        :start-day="$startDay"
                        :locale="$resolvedLocale"
                        :timezone="$resolvedTimezone"
                        :week-numbers="$weekNumbers"
                        :selectable-header="$selectableHeader"
                        :with-today="$withToday"
                        :fixed-weeks="$fixedWeeks"
                        :open-to="$openTo"
                        :force-open-to="$forceOpenTo"
                        :size="$size ?? 'default'"
                        :min-range="$minRange"
                        :max-range="$maxRange"
                    />
                </div>
            @endif

            @if ($withConfirmation)
                <x-stencil::date-picker.footer :$range />
            @endif
        </x-stencil::date-picker.panel>
    @else
        {{ $slot }}
    @endif
</div>
