@aware([
    'range' => false,
])

@props([
    'range' => false,
])

@php
    $panelLabel = $range
        ? __('stencil::messages.date_picker_range_placeholder')
        : __('stencil::messages.date_picker_placeholder');
@endphp

<div
    {{
        $attributes->class([
            'date-picker__panel z-50 w-max max-w-[calc(100vw-2rem)] rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-950',
        ])
    }}
    data-date-picker-panel
    hidden
    aria-hidden="true"
    tabindex="-1"
    aria-label="{{ $panelLabel }}"
>
    {{ $slot }}
</div>
