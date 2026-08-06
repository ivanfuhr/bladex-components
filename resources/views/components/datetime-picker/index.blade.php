<div
    {{ $attributes->class(['datetime-picker relative min-w-0', 'w-full' => ! filled($attributes->get('class'))]) }}
    data-datetime-picker
    data-datetime-picker-timezone="{{ $resolvedTimezone }}"
    data-datetime-picker-locale="{{ $resolvedLocale }}"
    data-datetime-picker-step="{{ $timeStep }}"
    @if ($withSeconds) data-datetime-picker-seconds @endif
>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $resolvedValue }}" data-datetime-picker-hidden-input />
    @else
        <input type="hidden" value="{{ $resolvedValue }}" data-datetime-picker-hidden-input />
    @endif

    @if ($shortcut)
        <x-std::date-picker.button
            :placeholder="$resolvedPlaceholder"
            :$invalid
            :$disabled
            :$clearable
            :$size
            :panel-id="$panelId"
            data-datetime-picker-trigger
        />

        <x-std::datetime-picker.panel :panel-id="$panelId">
            {{-- Absolute time column on md+ so list height tracks the calendar (no dead space). --}}
            <div class="relative flex flex-col md:flex-row">
                <div class="shrink-0 p-4">
                    <x-std::calendar
                        :value="$datePart"
                        :timezone="$resolvedTimezone"
                        :locale="$resolvedLocale"
                        :with-today="$withToday"
                        class="w-fit"
                        data-datetime-picker-calendar
                    />
                </div>

                <div class="hidden w-40 shrink-0 md:block" aria-hidden="true"></div>

                <x-std::datetime-picker.time-list :time-list-id="$timeListId" />
            </div>

            <x-std::datetime-picker.footer />
        </x-std::datetime-picker.panel>
    @else
        {{ $slot }}
    @endif
</div>
