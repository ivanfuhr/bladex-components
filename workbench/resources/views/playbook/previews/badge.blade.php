@php
    $variant = ($state['variant'] ?? 'secondary') === 'secondary' ? null : $state['variant'];
    $color = filled($state['color'] ?? '') ? $state['color'] : null;
    $rounded = (bool) ($state['rounded'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? false);
@endphp

<x-stencil::badge :variant="$variant" :color="$color" :rounded="$rounded">
    @if ($dismissible)
        Admin
        <x-stencil::badge.close />
    @else
        {{ $color === 'lime' ? 'New' : ($variant === 'destructive' ? 'Failed' : 'Badge') }}
    @endif
</x-stencil::badge>
