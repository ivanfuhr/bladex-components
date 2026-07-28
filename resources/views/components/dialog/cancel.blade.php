@props([
    'variant' => 'outline',
])

<x-stencil::button :variant="$variant" {{ $attributes->merge(['data-dialog-close' => true]) }}>
    {{ $slot }}
</x-stencil::button>
