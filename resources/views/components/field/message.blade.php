@props([
    'variant' => 'hint',
    'invalid' => false,
])

@aware([
    'fieldInvalid' => false,
])

@php
    $isError = $variant === 'error' || $invalid || $fieldInvalid;
    $messageVariant = $isError ? 'error' : 'subtle';

    $attributes = $attributes
        ->class('field__message')
        ->merge([
            'size' => 'sm',
            'variant' => $messageVariant,
            'data-field-message' => true,
            'data-field-message-variant' => $isError ? 'error' : 'hint',
        ]);

    if ($isError) {
        $attributes = $attributes->merge(['role' => 'alert']);
    }
@endphp

<x-stencil::text {{ $attributes }}> {{ $slot }} </x-stencil::text>
