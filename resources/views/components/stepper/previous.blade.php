@props([
    'text' => null,
])

<x-stencil::button
    type="button"
    variant="outline"
    {{
        $attributes->merge([
            'data-stepper-previous' => true,
            'aria-label' => __('stencil::messages.stepper_previous'),
        ])
    }}
>
    {{ $text ?? __('stencil::messages.stepper_previous') }}
</x-stencil::button>
