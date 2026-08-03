<x-ui::button
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
</x-ui::button>
