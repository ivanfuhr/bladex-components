<x-std::text
    variant="subtle"
    {{
        $attributes->except(['id'])->merge([
            'id' => $descriptionId,
            'data-dialog-description' => $descriptionId,
        ])
    }}
>
    {{ $slot }}
</x-std::text>
