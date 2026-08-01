@php
    $titleId = $attributes->get('id') ?? 'dialog-title-'.str_replace('.', '', uniqid('', true));
@endphp

<x-stencil::heading
    level="2"
    {{
        $attributes->except(['id'])->merge([
            'id' => $titleId,
            'data-dialog-title' => $titleId,
        ])
    }}
>
    {{ $slot }}
</x-stencil::heading>
