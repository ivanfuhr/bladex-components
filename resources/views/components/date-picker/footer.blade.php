@aware([
    'range' => false,
])

@props([
    'range' => false,
])

@php
    $confirmLabel = $range
        ? __('stencil::messages.date_picker_select_range')
        : __('stencil::messages.date_picker_select_date');
@endphp

<div class="mt-2 flex justify-end gap-2 border-t border-zinc-200 pt-2 dark:border-zinc-800">
    <x-stencil::button type="button" variant="ghost" data-date-picker-cancel>
        {{ __('stencil::messages.date_picker_cancel') }}
    </x-stencil::button>
    <x-stencil::button type="button" variant="primary" data-date-picker-confirm>
        {{ $confirmLabel }}
    </x-stencil::button>
</div>
