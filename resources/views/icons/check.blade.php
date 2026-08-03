{{-- Icon: check (Lucide, ISC) https://lucide.dev/icons/check --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="M20 6 9 17l-5-5" />
</x-ui::icon.lucide>
