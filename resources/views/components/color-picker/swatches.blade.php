@if ($slot->isNotEmpty())
    <div
        class="color-picker__swatches grid grid-cols-8 gap-1.5"
        data-color-picker-swatches
        role="listbox"
        aria-label="{{ __('Color swatches') }}"
    >
        {{ $slot }}
    </div>
@elseif ($palette !== [])
    <div
        class="color-picker__swatches grid grid-cols-8 gap-1.5"
        data-color-picker-swatches
        role="listbox"
        aria-label="{{ __('Color swatches') }}"
    >
        @foreach ($palette as $swatch)
            <x-ui::color-picker.swatch :value="$swatch['value']" :label="$swatch['label']" />
        @endforeach
    </div>
@endif
