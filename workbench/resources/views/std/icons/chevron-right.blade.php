{{-- Icon: chevron-right (Lucide, ISC) https://lucide.dev/icons/chevron-right --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m9 18 6-6-6-6" />
</x-std::icon.lucide>
