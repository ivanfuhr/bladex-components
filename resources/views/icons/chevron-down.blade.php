{{-- Icon: chevron-down (Lucide, ISC) https://lucide.dev/icons/chevron-down --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m6 9 6 6 6-6" />
</x-ui::icon.lucide>
