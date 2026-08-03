<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-color-picker-hidden-input />

    @if ($shortcut)
        <x-ui::color-picker.trigger :current-value="$currentValue" :popover-id="$popoverId" :$disabled :$invalid :$size>
            <x-ui::color-picker.hex
                :current-value="$currentValue"
                :popover-id="$popoverId"
                :placeholder-text="$placeholderText"
                :$disabled
                :$invalid
                :$size
            />
        </x-ui::color-picker.trigger>

        <x-ui::color-picker.content :popover-id="$popoverId">
            <x-ui::color-picker.area />

            <div class="flex items-center gap-2">
                <div class="relative min-w-0 flex-1">
                    <x-ui::color-picker.hue :$disabled />
                </div>

                @if ($dropper)
                    <x-ui::color-picker.dropper :$disabled />
                @endif
            </div>

            @if ($showSwatches && $swatchPalette !== [])
                <x-ui::color-picker.swatches :swatch-palette="$swatchPalette" :$disabled />
            @endif
        </x-ui::color-picker.content>
    @else
        {{ $slot }}
    @endif
</div>
