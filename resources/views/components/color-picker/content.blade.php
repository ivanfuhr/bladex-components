@aware([
    'popoverId' => null,
])

@props([
    'popoverId' => null,
])

@php
    $popoverClasses = collect([
        'color-picker__popover',
        'z-[200] flex w-[min(18rem,calc(100vw-1rem))] flex-col gap-3 rounded-md border border-zinc-200 bg-white p-3 shadow-md',
        'dark:border-zinc-800 dark:bg-zinc-950',
    ])->implode(' ');
@endphp

<div
    @if (filled($popoverId)) id="{{ $popoverId }}" @endif
    @class([$popoverClasses])
    data-color-picker-popover
    role="dialog"
    aria-label="{{ __('stencil::messages.color_picker_open') }}"
    hidden
>
    <div class="flex flex-col gap-3">
        {{ $slot }}
    </div>
</div>
