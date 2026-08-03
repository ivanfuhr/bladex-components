{{-- Icon: clock (Lucide, ISC) https://lucide.dev/icons/clock --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <circle cx="12" cy="12" r="10" />
    <path d="M12 6v6l4 2" />
</x-ui::icon.lucide>
