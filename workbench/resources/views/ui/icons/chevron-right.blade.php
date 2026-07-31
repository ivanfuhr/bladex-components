{{-- Icon: chevron-right (Lucide, ISC) https://lucide.dev/icons/chevron-right --}}
@props([
    'variant' => 'outline',
])

<x-stencil::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m9 18 6-6-6-6" />
</x-stencil::icon.lucide>
