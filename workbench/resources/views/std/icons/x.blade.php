{{-- Icon: x (Lucide, ISC) https://lucide.dev/icons/x --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="M18 6 6 18" />
    <path d="m6 6 12 12" />
</x-std::icon.lucide>
