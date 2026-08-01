<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a shortcut stat with label value trend and icon', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::stat
            label="Open tickets"
            value="128"
            trend="+12.4%"
            trend-direction="up"
            description="vs last 7 days"
            icon="file"
        />
    BLADE);

    expect($html)
        ->toContain('data-stat')
        ->toContain('data-stat-label')
        ->toContain('data-stat-value')
        ->toContain('data-stat-trend')
        ->toContain('data-direction="up"')
        ->toContain('data-stat-description')
        ->toContain('data-stat-icon')
        ->toContain('Open tickets')
        ->toContain('128')
        ->toContain('+12.4%')
        ->toContain('vs last 7 days')
        ->toContain('data-trend-direction="up"');
});

it('renders composable stat parts and variants', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::stat variant="muted">
            <x-stencil::stat.label>Resolved</x-stencil::stat.label>
            <x-stencil::stat.value>86%</x-stencil::stat.value>
            <x-stencil::stat.trend direction="down">−2.1%</x-stencil::stat.trend>
            <x-stencil::stat.description>This week</x-stencil::stat.description>
        </x-stencil::stat>
    BLADE);

    expect($html)
        ->toContain('data-variant="muted"')
        ->toContain('Resolved')
        ->toContain('86%')
        ->toContain('data-direction="down"')
        ->toContain('−2.1%')
        ->toContain('This week');
});

it('supports outline variant', function () {
    $html = Blade::render('<x-stencil::stat variant="outline" label="Queue" value="12" />');

    expect($html)
        ->toContain('data-variant="outline"')
        ->toContain('Queue')
        ->toContain('12');
});
