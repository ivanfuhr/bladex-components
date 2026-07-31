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
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    $invalid = $invalid || $fieldInvalid;

    $comboboxId = filled($comboboxId)
        ? $comboboxId
        : (filled($name) ? $name : 'combobox-'.str_replace('.', '', uniqid('', true)));
    $listboxId = filled($listboxId) ? $listboxId : $comboboxId.'-listbox';
    $controlId = filled($controlId) ? $controlId : $comboboxId;

    $scalarValue = filled($value) ? (string) $value : '';

    $emptyMessage = filled($empty)
        ? (string) $empty
        : __('stencil::messages.combobox_empty');

    $rootAttributes = $attributes
        ->except('shortcut')
        ->class([
            'combobox relative min-w-0',
            'w-full' => ! filled($attributes->get('class')),
        ]);
@endphp

<div {{ $rootAttributes }} data-combobox data-combobox-id="{{ $comboboxId }}">
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $scalarValue }}" data-combobox-hidden-input />
    @else
        <input type="hidden" value="{{ $scalarValue }}" data-combobox-hidden-input />
    @endif

    @if ($shortcut)
        <x-stencil::combobox.input :placeholder="$placeholder" />

        <x-stencil::combobox.content>
            <x-stencil::combobox.empty>{{ $emptyMessage }}</x-stencil::combobox.empty>
            {{ $slot }}
        </x-stencil::combobox.content>
    @else
        {{ $slot }}
    @endif
</div>
