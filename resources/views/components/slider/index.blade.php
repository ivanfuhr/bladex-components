<div {{ $rootAttributes }}>
    @foreach ($formattedValues as $index => $formattedValue)
        @if (filled($name))
            <input
                type="hidden"
                name="{{ $isRange ? $name.'['.$index.']' : $name }}"
                value="{{ $formattedValue }}"
                data-slider-hidden-input
                data-index="{{ $index }}"
            />
        @else
            <input type="hidden" value="{{ $formattedValue }}" data-slider-hidden-input data-index="{{ $index }}" />
        @endif
    @endforeach

    @if ($shortcut)
        <x-ui::slider.track>
            <x-ui::slider.range />
        </x-ui::slider.track>
        @foreach ($values as $index => $thumbValue)
            <x-ui::slider.thumb
                :index="$index"
                :value="$thumbValue"
                :range="$isRange"
                :invalid="$invalid"
                :disabled="$disabled"
                :size="$size"
                :min="$min"
                :max="$max"
                :step="$step"
                :slider-id="$sliderId"
                :name="$name"
            />
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>
