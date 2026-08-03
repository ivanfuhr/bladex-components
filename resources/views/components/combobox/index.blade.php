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
            <x-ui::combobox.input
                :placeholder="$placeholder"
                :multiple="true"
                :invalid="$resolvedInvalid"
                :disabled="$disabled"
                :combobox-id="$comboboxId"
                :listbox-id="$listboxId"
                :control-id="$controlId"
            >
                <x-ui::combobox.chips :placeholder="$placeholder" />
            </x-ui::combobox.input>
        @else
            <x-ui::combobox.input
                :placeholder="$placeholder"
                :multiple="$multiple"
                :invalid="$resolvedInvalid"
                :disabled="$disabled"
                :combobox-id="$comboboxId"
                :listbox-id="$listboxId"
                :control-id="$controlId"
            />
        @endif

        <x-ui::combobox.content>
            <x-ui::combobox.empty>{{ $emptyMessage }}</x-ui::combobox.empty>
            {{ $slot }}
        </x-ui::combobox.content>
    @else
        {{ $slot }}
    @endif
</div>
