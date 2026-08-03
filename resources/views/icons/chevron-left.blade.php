{{-- Icon: chevron-left (Lucide, ISC) https://lucide.dev/icons/chevron-left --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="m15 18-6-6 6-6" />
</x-ui::icon.lucide>
