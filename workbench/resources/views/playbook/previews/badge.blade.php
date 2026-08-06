@php
    $variant = ($state['variant'] ?? 'secondary') === 'secondary' ? null : $state['variant'];
    $color = filled($state['color'] ?? '') ? $state['color'] : null;
    $rounded = (bool) ($state['rounded'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? false);
@endphp

<x-std::badge :variant="$variant" :color="$color" :rounded="$rounded">
    @if ($dismissible)
        Admin
        <x-std::badge.close />
    @else
        {{ $color === 'lime' ? 'New' : ($variant === 'destructive' ? 'Failed' : 'Badge') }}
    @endif
</x-std::badge>
