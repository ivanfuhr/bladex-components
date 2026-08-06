{{-- Icon: check (Lucide, ISC) https://lucide.dev/icons/check --}}
@props([
    'variant' => 'outline',
])

<x-std::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="M20 6 9 17l-5-5" />
</x-std::icon.lucide>
