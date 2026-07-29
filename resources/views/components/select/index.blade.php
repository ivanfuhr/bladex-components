@props([
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'selectId' => null,
    'listboxId' => null,
    'shortcut' => true,
    'multiple' => false,
    'display' => 'count',
])

@aware([
    'fieldInvalid' => false,
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

    $selectId = filled($selectId)
        ? $selectId
        : 'select-'.str_replace('.', '', uniqid('', true));
    $listboxId = filled($listboxId) ? $listboxId : $selectId.'-listbox';

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

    $rootAttributes = $attributes
        ->except('shortcut')
        ->class([
            'select relative min-w-0',
            'w-full' => ! filled($attributes->get('class')),
        ]);

    if ($multiple) {
        $rootAttributes = $rootAttributes->merge([
            'data-select-multiple' => true,
            'data-select-display' => $display,
            'data-select-count-template' => $countTemplate,
            'data-select-chip-remove-label' => $chipRemoveLabel,
        ]);
    }
@endphp

<div
    {{ $rootAttributes }}
    data-select
    data-select-id="{{ $selectId }}"
>
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
                    <input
                        type="hidden"
                        value="{{ $selectedValue }}"
                        data-select-hidden-input
                    />
                @endif
            @endforeach
        </div>
    @else
        @if (filled($name))
            <input
                type="hidden"
                name="{{ $name }}"
                value="{{ $scalarValue }}"
                data-select-hidden-input
            />
        @else
            <input
                type="hidden"
                value="{{ $scalarValue }}"
                data-select-hidden-input
            />
        @endif
    @endif

    @if ($shortcut)
        <x-stencil::select.trigger>
            @if ($multiple && $display === 'chips')
                <x-stencil::select.chips />
            @else
                <x-stencil::select.value :placeholder="$placeholder" />
            @endif
        </x-stencil::select.trigger>

        <x-stencil::select.content>
            {{ $slot }}
        </x-stencil::select.content>
    @else
        {{ $slot }}
    @endif
</div>
