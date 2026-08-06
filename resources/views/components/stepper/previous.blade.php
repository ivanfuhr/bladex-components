<x-std::button
    type="button"
    variant="outline"
    {{
        $attributes->merge([
            'data-stepper-previous' => true,
            'aria-label' => __('Previous'),
        ])
    }}
>
    {{ $text ?? __('Previous') }}
</x-std::button>
