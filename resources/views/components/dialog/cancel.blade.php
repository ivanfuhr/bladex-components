<x-ui::button :variant="$variant" {{ $attributes->merge(['data-dialog-close' => true, 'data-dialog-cancel' => true]) }}>
    {{ $slot }}
</x-ui::button>
