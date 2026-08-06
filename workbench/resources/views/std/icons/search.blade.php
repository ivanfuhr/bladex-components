{{-- Icon: search (Lucide, ISC) https://lucide.dev/icons/search --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <circle cx="11" cy="11" r="8" />
    <path d="m21 21-4.34-4.34" />
</x-std::icon.lucide>
