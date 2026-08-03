{{-- Icon: grip-vertical (Lucide, ISC) https://lucide.dev/icons/grip-vertical --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <circle cx="9" cy="12" r="1" />
    <circle cx="9" cy="5" r="1" />
    <circle cx="9" cy="19" r="1" />
    <circle cx="15" cy="12" r="1" />
    <circle cx="15" cy="5" r="1" />
    <circle cx="15" cy="19" r="1" />
</x-ui::icon.lucide>
