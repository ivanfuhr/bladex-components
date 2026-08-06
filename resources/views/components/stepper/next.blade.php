<x-std::button
    type="button"
    variant="primary"
    {{
        $attributes->merge([
            'data-stepper-next' => true,
            'aria-label' => __('Next'),
        ])
    }}
>
    {{ $text ?? __('Next') }}
</x-std::button>
