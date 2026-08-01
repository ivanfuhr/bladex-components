@props([
    'text' => null,
])

<x-stencil::button
    type="button"
    variant="primary"
    {{
        $attributes->merge([
            'data-stepper-next' => true,
            'aria-label' => __('stencil::messages.stepper_next'),
        ])
    }}
>
    {{ $text ?? __('stencil::messages.stepper_next') }}
</x-stencil::button>
