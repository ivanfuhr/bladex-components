@props([
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'empty' => null,
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'comboboxId' => null,
    'listboxId' => null,
    'shortcut' => true,
    'multiple' => false,
    'display' => 'count',
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    $invalid = $invalid || $fieldInvalid;
    $multiple = (bool) $multiple;
    $display = in_array($display, ['count', 'chips'], true) ? $display : 'count';

    if (! $multiple) {
        $display = 'count';
    }

    $comboboxId = filled($comboboxId)
        ? $comboboxId
        : (filled($name) ? $name : 'combobox-'.str_replace('.', '', uniqid('', true)));
    $listboxId = filled($listboxId) ? $listboxId : $comboboxId.'-listbox';
    $controlId = filled($controlId) ? $controlId : $comboboxId;

    $fieldName = $name;

    if ($multiple && filled($name) && ! Str::endsWith($name, '[]')) {
        $fieldName = $name.'[]';
    }

    $selectedValues = $multiple
        ? collect(Arr::wrap($value))
            ->filter(fn ($item) => filled($item))
            ->map(fn ($item) => (string) $item)
            ->values()
            ->all()
        : [];

    $scalarValue = $multiple ? null : (filled($value) ? (string) $value : '');

    $countTemplate = __('stencil::messages.select_selected_count', ['count' => '{count}']);
    $chipRemoveLabel = __('stencil::messages.select_remove_chip');

    $emptyMessage = filled($empty)
        ? (string) $empty
        : __('stencil::messages.combobox_empty');

    $rootAttributes = $attributes
        ->except('shortcut')
        ->class([
            'combobox relative min-w-0',
            'w-full' => ! filled($attributes->get('class')),
        ]);

    if ($multiple) {
        $rootAttributes = $rootAttributes->merge([
            'data-combobox-multiple' => true,
            'data-combobox-display' => $display,
            'data-combobox-count-template' => $countTemplate,
            'data-combobox-chip-remove-label' => $chipRemoveLabel,
        ]);
    }
@endphp

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
            <x-stencil::combobox.input :placeholder="$placeholder" :multiple="true">
                <x-stencil::combobox.chips :placeholder="$placeholder" />
            </x-stencil::combobox.input>
        @else
            <x-stencil::combobox.input :placeholder="$placeholder" :multiple="$multiple" />
        @endif

        <x-stencil::combobox.content>
            <x-stencil::combobox.empty>{{ $emptyMessage }}</x-stencil::combobox.empty>
            {{ $slot }}
        </x-stencil::combobox.content>
    @else
        {{ $slot }}
    @endif
</div>
