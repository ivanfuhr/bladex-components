@props([
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'type' => 'button',
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'size' => null,
    'withSeconds' => false,
    'step' => 30,
    'unavailable' => null,
    'timezone' => null,
    'locale' => null,
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
    $resolvedValue = DateFormatter::normalizeTimeValue($value, $withSeconds);
    $resolvedPlaceholder = $placeholder ?? __('stencil::messages.time_picker_placeholder');

    if (is_array($unavailable)) {
        $unavailable = collect($unavailable)->implode(',');
    }
@endphp

<div
    {{ $attributes->except(['shortcut'])->class(['time-picker relative min-w-0', 'w-full' => ! filled($attributes->get('class'))]) }}
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
            <x-stencil::time-picker.input :$placeholder :$invalid :$disabled :$clearable :$size />
        @else
            <x-stencil::time-picker.button :$placeholder :$invalid :$disabled :$clearable :$size />
        @endif
    @else
        {{ $slot }}
    @endif

    <div
        class="time-picker__panel fixed z-50 hidden max-h-80 min-w-48 overflow-y-auto rounded-lg border border-zinc-200 bg-white p-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-950"
        data-time-picker-panel
        role="listbox"
        tabindex="-1"
        hidden
    ></div>
</div>
