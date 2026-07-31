{{-- Icon: plus (Lucide, ISC) https://lucide.dev/icons/plus --}}
@props([
    'variant' => 'outline',
])

<x-stencil::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="M5 12h14" />
    <path d="M12 5v14" />
</x-stencil::icon.lucide>
