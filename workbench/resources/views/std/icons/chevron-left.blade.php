{{-- Icon: chevron-left (Lucide, ISC) https://lucide.dev/icons/chevron-left --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m15 18-6-6 6-6" />
</x-std::icon.lucide>
