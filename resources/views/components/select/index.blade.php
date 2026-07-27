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
])

@aware([
    'fieldInvalid' => false,
])

@php
    $invalid = $invalid || $fieldInvalid;

    $selectId = filled($selectId)
        ? $selectId
        : 'select-'.str_replace('.', '', uniqid('', true));
    $listboxId = filled($listboxId) ? $listboxId : $selectId.'-listbox';
@endphp

<div
    {{ $attributes->except('shortcut')->class([
        'select relative min-w-0',
        'w-full' => ! filled($attributes->get('class')),
    ]) }}
    data-select
    data-select-id="{{ $selectId }}"
>
    @if (filled($name))
        <input
            type="hidden"
            name="{{ $name }}"
            value="{{ $value }}"
            data-select-hidden-input
        />
    @else
        <input
            type="hidden"
            value="{{ $value }}"
            data-select-hidden-input
        />
    @endif

    @if ($shortcut)
        <x-stencil::select.trigger>
            <x-stencil::select.value :placeholder="$placeholder" />
        </x-stencil::select.trigger>

        <x-stencil::select.content>
            {{ $slot }}
        </x-stencil::select.content>
    @else
        {{ $slot }}
    @endif
</div>
