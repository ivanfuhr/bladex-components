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
    use Ivanfuhr\Stencil\Support\Chrono\ChronoFormatter;
    use Ivanfuhr\Stencil\Support\Chrono\DateRangePreset;

    $invalid = $invalid || $fieldInvalid;
    $range = $mode === 'range';
    $resolvedTimezone = ChronoFormatter::resolveTimezone($timezone);
    $resolvedLocale = $locale ?? app()->getLocale();
    $resolvedValue = ChronoFormatter::normalizeDateValue($value, $mode);
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

    @if (isset($trigger))
        {{ $trigger }}
    @elseif ($shortcut)
        @if ($type === 'input')
            <x-stencil::date-picker.input :$placeholder :$invalid :$disabled :$clearable :$size />
        @else
            <x-stencil::date-picker.button :$placeholder :$invalid :$disabled :$clearable :$size />
        @endif
    @else
        {{ $slot }}
    @endif

    <div
        class="date-picker__panel z-50 w-max max-w-[calc(100vw-2rem)] rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-950"
        data-date-picker-panel
        hidden
        aria-hidden="true"
        tabindex="-1"
        aria-label="{{ $range ? __('stencil::messages.date_picker_range_placeholder') : __('stencil::messages.date_picker_placeholder') }}"
    >
        <div class="grid sm:grid-cols-[auto_1fr]">
            @if ($presetMeta !== [])
                <div class="hidden border-e border-zinc-200 p-2 sm:block dark:border-zinc-800" data-date-picker-presets>
                    @foreach ($presetMeta as $preset)
                        <button
                            type="button"
                            class="block w-full rounded-lg px-2 py-1.5 text-left text-sm text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800"
                            data-date-picker-preset="{{ $preset['key'] }}"
                            data-date-picker-preset-start="{{ $preset['start'] }}"
                            data-date-picker-preset-end="{{ $preset['end'] }}"
                        >
                            {{ $preset['label'] }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="min-w-0">
                @if ($withInputs)
                    <div class="mb-2 border-b border-zinc-200 pb-2 dark:border-zinc-800" data-date-picker-manual-inputs>
                        <x-stencil::input type="text" placeholder="YYYY-MM-DD" data-date-picker-manual-input />
                    </div>
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
        </div>

        @if ($withConfirmation)
            <div class="mt-2 flex justify-end gap-2 border-t border-zinc-200 pt-2 dark:border-zinc-800">
                <x-stencil::button type="button" variant="ghost" data-date-picker-cancel>
                    {{ __('stencil::messages.date_picker_cancel') }}
                </x-stencil::button>
                <x-stencil::button type="button" variant="primary" data-date-picker-confirm>
                    {{ $range ? __('stencil::messages.date_picker_select_range') : __('stencil::messages.date_picker_select_date') }}
                </x-stencil::button>
            </div>
        @endif
    </div>
</div>
