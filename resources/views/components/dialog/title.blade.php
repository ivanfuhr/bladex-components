<x-ui::heading
    level="2"
    {{
        $attributes->except(['id'])->merge([
            'id' => $titleId,
            'data-dialog-title' => $titleId,
        ])
    }}
>
    {{ $slot }}
</x-ui::heading>
