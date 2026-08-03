<div @class([$triggerClasses]) data-color-picker-trigger>
    <button
        type="button"
        @class([$swatchButtonClasses])
        data-color-picker-swatch-trigger
        aria-label="{{ __('Open color picker') }}"
        @if (filled($popoverId)) aria-controls="{{ $popoverId }}" @endif
        aria-expanded="false"
        aria-haspopup="dialog"
        @if ($disabled) disabled @endif
    >
        <span
            class="{{ $previewClasses }}"
            data-color-picker-preview
            style="background-color: {{ $currentValue }}"
            aria-hidden="true"
        ></span>
    </button>

    {{ $slot }}
</div>
