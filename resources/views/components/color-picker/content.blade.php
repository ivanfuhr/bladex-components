<div
    @if (filled($popoverId)) id="{{ $popoverId }}" @endif
    @class([$popoverClasses])
    data-color-picker-popover
    role="dialog"
    aria-label="{{ __('Open color picker') }}"
    hidden
>
    <div class="flex flex-col gap-3">{{ $slot }}</div>
</div>
