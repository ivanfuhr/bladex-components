@aware([
    'titleId' => null,
])

<x-stencil::heading
    level="2"
    {{
        $attributes->merge([
            'id' => $titleId,
            'data-dialog-title' => true,
        ])
    }}
>
    {{ $slot }}
</x-stencil::heading>
