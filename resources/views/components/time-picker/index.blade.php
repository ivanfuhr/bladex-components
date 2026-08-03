<div
    {{ $attributes->class(['time-picker relative min-w-0', 'w-full' => ! filled($attributes->get('class'))]) }}
    data-time-picker
    data-time-picker-step="{{ $step }}"
    @if ($withSeconds) data-time-picker-seconds @endif
    data-time-picker-locale="{{ $resolvedLocale }}"
    data-time-picker-timezone="{{ $resolvedTimezone }}"
    @if (filled($unavailable)) data-time-picker-unavailable="{{ $unavailable }}" @endif
>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $resolvedValue }}" data-time-picker-hidden-input />
    @else
        <input type="hidden" value="{{ $resolvedValue }}" data-time-picker-hidden-input />
    @endif

    @if ($shortcut)
        @if ($type === 'input')
            <x-ui::time-picker.input :$placeholder :$invalid :$disabled :$clearable :$size />
        @else
            <x-ui::time-picker.button :$placeholder :$invalid :$disabled :$clearable :$size />
        @endif
    @else
        {{ $slot }}
    @endif

    <div
        class="time-picker__panel fixed z-50 max-h-80 min-w-48 overflow-y-auto rounded-lg border border-zinc-200 bg-white p-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-950"
        data-time-picker-panel
        role="listbox"
        tabindex="-1"
        hidden
    ></div>
</div>
