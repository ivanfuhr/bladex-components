{{-- Icon: calendar (Lucide, ISC) https://lucide.dev/icons/calendar --}}
@props([
    'variant' => 'outline',
])

<x-stencil::icon.lucide :variant="$variant" {{ $attributes }}>
    <path d="M8 2v3" />
      <path d="M16 2v3" />
      <rect x="3" y="3" width="18" height="18" rx="2" />
      <path d="M3 9h18" />
</x-stencil::icon.lucide>