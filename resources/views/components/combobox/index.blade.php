<div {{ $rootAttributes }} data-combobox data-combobox-id="{{ $comboboxId }}">
    @if ($multiple)
        <div data-combobox-hidden-inputs @if (filled($fieldName)) data-combobox-field-name="{{ $fieldName }}" @endif>
            @foreach ($selectedValues as $selectedValue)
                @if (filled($fieldName))
                    <input
                        type="hidden"
                        name="{{ $fieldName }}"
                        value="{{ $selectedValue }}"
                        data-combobox-hidden-input
                    />
                @else
                    <input type="hidden" value="{{ $selectedValue }}" data-combobox-hidden-input />
                @endif
            @endforeach
        </div>
    @else
        @if (filled($name))
            <input type="hidden" name="{{ $name }}" value="{{ $scalarValue }}" data-combobox-hidden-input />
        @else
            <input type="hidden" value="{{ $scalarValue }}" data-combobox-hidden-input />
        @endif
    @endif

    @if ($shortcut)
        @if ($multiple && $display === 'chips')
            <x-std::combobox.input
                :placeholder="$placeholder"
                :multiple="true"
                :invalid="$resolvedInvalid"
                :disabled="$disabled"
                :combobox-id="$comboboxId"
                :listbox-id="$listboxId"
                :control-id="$controlId"
            >
                <x-std::combobox.chips :placeholder="$placeholder" />
            </x-std::combobox.input>
        @else
            <x-std::combobox.input
                :placeholder="$placeholder"
                :multiple="$multiple"
                :invalid="$resolvedInvalid"
                :disabled="$disabled"
                :combobox-id="$comboboxId"
                :listbox-id="$listboxId"
                :control-id="$controlId"
            />
        @endif

        <x-std::combobox.content>
            <x-std::combobox.empty>{{ $emptyMessage }}</x-std::combobox.empty>
            {{ $slot }}
        </x-std::combobox.content>
    @else
        {{ $slot }}
    @endif
</div>
