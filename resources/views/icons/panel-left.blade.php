{{-- Icon: panel-left (Lucide, ISC) https://lucide.dev/icons/panel-left --}}
@props([
    'variant' => 'outline',
])

<x-ui::icon.lucide :variant="$variant" {{ $attributes }}>
    <rect width="18" height="18" x="3" y="3" rx="2" />
    <path d="M9 3v18" />
</x-ui::icon.lucide>
