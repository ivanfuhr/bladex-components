@aware([
    'descriptionId' => null,
])

<x-stencil::text
    variant="subtle"
    {{
        $attributes->merge([
            'id' => $descriptionId,
            'data-dialog-description' => true,
        ])
    }}
>
    {{ $slot }}
</x-stencil::text>
