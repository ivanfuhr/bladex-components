@php
    $descriptionId = $attributes->get('id') ?? 'dialog-description-'.str_replace('.', '', uniqid('', true));
@endphp

<x-stencil::text
    variant="subtle"
    {{
        $attributes->except(['id'])->merge([
            'id' => $descriptionId,
            'data-dialog-description' => $descriptionId,
        ])
    }}
>
    {{ $slot }}
</x-stencil::text>
