@php
    $md = (string) ($state['md'] ?? '3');
    $sm = filled($state['sm'] ?? null) ? (string) $state['sm'] : null;
    $container = (bool) ($state['container'] ?? true);
    $showSpan = (bool) ($state['show_span'] ?? true);
@endphp

<x-std::grid :md="$md" :sm="$sm" gap="4" class="w-full max-w-3xl" :container="$container">
    <x-std::stat
        label="Registrations"
        value="248"
        trend="+12.4%"
        trend-direction="up"
        description="vs last 7 days"
        icon="file"
    />
    <x-std::stat
        label="Revenue"
        value="R$ 46.8k"
        trend="+8.2%"
        trend-direction="up"
        description="Ticket sales"
        icon="clock"
    />
    @if ($showSpan)
        <x-std::grid.item span="full">
            <x-std::stat
                variant="muted"
                label="Check-in rate"
                value="64%"
                trend="−2.1%"
                trend-direction="down"
                description="Full-width row via grid.item"
                icon="check"
            />
        </x-std::grid.item>
    @else
        <x-std::stat
            label="Check-in rate"
            value="64%"
            trend="−2.1%"
            trend-direction="down"
            description="Doors open day one"
            icon="check"
        />
    @endif
</x-std::grid>
