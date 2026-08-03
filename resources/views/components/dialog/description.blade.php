<x-ui::text
    variant="subtle"
    {{
        $attributes->except(['id'])->merge([
            'id' => $descriptionId,
            'data-dialog-description' => $descriptionId,
        ])
    }}
>
    {{ $slot }}
</x-ui::text>
