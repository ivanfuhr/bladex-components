<div
    {{
        $attributes->class([
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
            <x-ui::date-picker.input :$placeholder :$invalid :$disabled :$clearable :$size :panel-id="$panelId" />
        @else
            <x-ui::date-picker.button :$placeholder :$invalid :$disabled :$clearable :$size :panel-id="$panelId" />
        @endif

        <x-ui::date-picker.panel :$range :panel-id="$panelId">
            @if ($withPresets && $presetMeta !== [])
                <x-ui::date-picker.presets :preset-meta="$presetMeta">
                    @if ($withInputs)
                        <x-ui::date-picker.manual-inputs />
                    @endif

                    <x-ui::calendar
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
                </x-ui::date-picker.presets>
            @else
                <div class="min-w-0">
                    @if ($withInputs)
                        <x-ui::date-picker.manual-inputs />
                    @endif

                    <x-ui::calendar
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
                <x-ui::date-picker.footer :$range />
            @endif
        </x-ui::date-picker.panel>
    @else
        {{ $slot }}
    @endif
</div>
