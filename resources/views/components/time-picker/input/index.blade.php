@aware([
    'placeholder' => null,
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'size' => null,
])

<x-stencil::input
    {{ $attributes->merge([
        'type' => 'text',
        'placeholder' => $placeholder,
        'invalid' => $invalid,
        'disabled' => $disabled,
        'size' => $size,
        'readonly' => true,
        'data-time-picker-trigger' => true,
        'data-time-picker-input' => true,
    ]) }}
/>
