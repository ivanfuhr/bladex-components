<div {{ $rootAttributes }} data-select data-select-id="{{ $selectId }}">
    @if ($multiple)
        <div data-select-hidden-inputs @if (filled($fieldName)) data-select-field-name="{{ $fieldName }}" @endif>
            @foreach ($selectedValues as $selectedValue)
                @if (filled($fieldName))
                    <input
                        type="hidden"
                        name="{{ $fieldName }}"
                        value="{{ $selectedValue }}"
                        data-select-hidden-input
                    />
                @else
                    <input type="hidden" value="{{ $selectedValue }}" data-select-hidden-input />
                @endif
            @endforeach
        </div>
    @else
        @if (filled($name))
            <input type="hidden" name="{{ $name }}" value="{{ $scalarValue }}" data-select-hidden-input />
        @else
            <input type="hidden" value="{{ $scalarValue }}" data-select-hidden-input />
        @endif
    @endif

    @if ($shortcut)
        <x-std::select.trigger
            :size="$size"
            :invalid="$invalid"
            :disabled="$disabled"
            :select-id="$selectId"
            :listbox-id="$listboxId"
            :multiple="$multiple"
            :display="$display"
            :control-id="$controlId"
        >
            @if ($multiple && $display === 'chips')
                <x-std::select.chips :placeholder="$placeholder" :size="$size" />
            @else
                <x-std::select.value :placeholder="$placeholder" />
            @endif
        </x-std::select.trigger>

        <x-std::select.content :listbox-id="$listboxId" :size="$size" :multiple="$multiple">
            {{ $slot }}
        </x-std::select.content>
    @else
        {{ $slot }}
    @endif
</div>
