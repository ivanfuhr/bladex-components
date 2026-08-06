<x-std::text
    size="sm"
    :variant="$messageVariant"
    {{
        $attributes->class('field__message')->merge([
            'data-field-message' => true,
            'data-field-message-variant' => $isError ? 'error' : 'hint',
            'role' => $isError ? 'alert' : null,
        ])
    }}
>
    {{ $slot }}
</x-std::text>
