<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-color-picker-hidden-input />

    @if ($shortcut)
        <x-std::color-picker.trigger
            :current-value="$currentValue"
            :popover-id="$popoverId"
            :$disabled
            :$invalid
            :$size
        >
            <x-std::color-picker.hex
                :current-value="$currentValue"
                :popover-id="$popoverId"
                :placeholder-text="$placeholderText"
                :$disabled
                :$invalid
                :$size
            />
        </x-std::color-picker.trigger>

        <x-std::color-picker.content :popover-id="$popoverId">
            <x-std::color-picker.area />

            <div class="flex items-center gap-2">
                <div class="relative min-w-0 flex-1">
                    <x-std::color-picker.hue :$disabled />
                </div>

                @if ($dropper)
                    <x-std::color-picker.dropper :$disabled />
                @endif
            </div>

            @if ($showSwatches && $swatchPalette !== [])
                <x-std::color-picker.swatches :swatch-palette="$swatchPalette" :$disabled />
            @endif
        </x-std::color-picker.content>
    @else
        {{ $slot }}
    @endif
</div>
