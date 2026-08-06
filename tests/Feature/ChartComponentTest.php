<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a composable chart with data templates and slots', function () {
    $data = [
        ['date' => '2026-08-01', 'visitors' => 267],
        ['date' => '2026-07-31', 'visitors' => 259],
    ];

    $html = Blade::render(<<<'BLADE'
        <x-std::chart :value="$data" class="aspect-[3/1]">
            <x-std::chart.svg>
                <x-std::chart.line field="visitors" class="text-[var(--chart-3)]" />
                <x-std::chart.axis axis="x" field="date">
                    <x-std::chart.axis.line />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.axis axis="y">
                    <x-std::chart.axis.grid />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.cursor />
            </x-std::chart.svg>
            <x-std::chart.tooltip>
                <x-std::chart.tooltip.heading field="date" />
                <x-std::chart.tooltip.value field="visitors" label="Visitors" />
            </x-std::chart.tooltip>
        </x-std::chart>
    BLADE, ['data' => $data]);

    expect($html)
        ->toContain('data-chart')
        ->toContain('data-chart-value')
        ->toContain('data-chart-template="svg"')
        ->toContain('data-chart-template="line"')
        ->toContain('data-field="visitors"')
        ->toContain('<svg class="absolute inset-0 size-full"')
        ->not->toContain('<svg class="absolute inset-0 size-full" xmlns="http://www.w3.org/2000/svg" version="1.1">\n        <template data-chart-template="line"')
        ->toContain('data-chart-template="axis"')
        ->toContain('data-axis="x"')
        ->toContain('data-chart-template="tooltip"')
        ->toContain('data-chart-slot')
        ->toContain('data-field="date"')
        ->toContain('Visitors')
        ->toContain('2026-08-01')
        ->toContain('267');
});

it('renders a sparkline shortcut with flat numeric data', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::chart :value="[15, 18, 16, 19]" class="w-32 aspect-[3/1]">
            <x-std::chart.svg gutter="0">
                <x-std::chart.line class="text-[var(--chart-4)]" />
            </x-std::chart.svg>
        </x-std::chart>
    BLADE);

    expect($html)
        ->toContain('data-chart')
        ->toContain('aria-label="Chart"')
        ->toContain('data-gutter="0"')
        ->toContain('data-chart-template="line"')
        ->toContain('data-field="value"')
        ->toContain('15')
        ->toContain('18');
});

it('exports chart runtime helpers from chart.js', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/chart.js');

    expect($source)
        ->toContain("export const ROOT_SELECTOR = '[data-chart]'")
        ->toContain('export function initCharts')
        ->toContain('collectChartAnnouncementParts');
});

it('defaults chart svg gutters so edge tick labels stay inside the paint box', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/chart.js');

    expect($source)
        ->toContain("gutter ?? '28 36 32 40'")
        ->toContain('top: parts[0] ?? 28')
        ->toContain('right: parts[1] ?? 36')
        ->not->toContain("gutter ?? '24 16 32 40'");
});

it('renders accessible chart landmarks and live region support', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::chart :value="[['month' => 'Jan', 'revenue' => 4200], ['month' => 'Feb', 'revenue' => 3800]]" label="Monthly revenue">
            <x-std::chart.svg>
                <x-std::chart.bar field="revenue" />
                <x-std::chart.axis axis="x" field="month">
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.axis axis="y" tick-prefix="$">
                    <x-std::chart.axis.grid />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
            </x-std::chart.svg>
            <x-std::chart.tooltip>
                <x-std::chart.tooltip.heading field="month" />
                <x-std::chart.tooltip.value field="revenue" label="Revenue" prefix="$" />
            </x-std::chart.tooltip>
        </x-std::chart>
    BLADE);

    expect($html)
        ->toContain('role="figure"')
        ->toContain('tabindex="0"')
        ->toContain('aria-label="Monthly revenue"')
        ->toContain('data-chart-announcer')
        ->toContain('aria-live="polite"')
        ->toContain('data-tick-prefix="$"')
        ->toContain('data-prefix="$"')
        ->toContain('role="status"');
});

it('renders bar series templates with owned svg primitives', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::chart :value="[['month' => 'Jan', 'revenue' => 4200], ['month' => 'Feb', 'revenue' => 3800]]">
            <x-std::chart.svg>
                <x-std::chart.bar field="revenue" width="70%" />
            </x-std::chart.svg>
        </x-std::chart>
    BLADE);

    expect($html)
        ->toContain('data-chart-template="bar"')
        ->toContain('data-field="revenue"')
        ->toContain('data-width="70%"');
});
