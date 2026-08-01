@php
    $variant = ($state['variant'] ?? 'default') === 'default' ? null : $state['variant'];
    $trendDirection = $state['trend_direction'] ?? 'up';
    $showIcon = (bool) ($state['show_icon'] ?? true);

    $trend = match ($trendDirection) {
        'down' => '−4.1%',
        'neutral' => '0.0%',
        default => '+12.4%',
    };
@endphp

<div class="grid w-full max-w-3xl gap-4 sm:grid-cols-3">
    <x-stencil::stat
        :variant="$variant"
        label="Open tickets"
        value="128"
        :trend="$trend"
        :trend-direction="$trendDirection"
        description="vs last 7 days"
        :icon="$showIcon ? 'file' : null"
    />
    <x-stencil::stat
        :variant="$variant"
        label="Avg. response"
        value="2.4h"
        trend="−18m"
        trend-direction="up"
        description="First reply time"
        :icon="$showIcon ? 'clock' : null"
    />
    <x-stencil::stat
        :variant="$variant"
        label="Resolved"
        value="86%"
        trend="+3.2%"
        trend-direction="up"
        description="This week"
        :icon="$showIcon ? 'check' : null"
    />
</div>
