{{-- Icon: chevron-down (Lucide, ISC) https://lucide.dev/icons/chevron-down --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m6 9 6 6 6-6" />
</x-std::icon.lucide>
