<x-std::heading
    level="2"
    {{
        $attributes->except(['id'])->merge([
            'id' => $titleId,
            'data-dialog-title' => $titleId,
        ])
    }}
>
    {{ $slot }}
</x-std::heading>
