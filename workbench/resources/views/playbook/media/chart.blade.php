@extends('workbench::playbook.media.layout')

@php
    $data = [
        ['date' => '2026-07-28', 'visitors' => 241],
        ['date' => '2026-07-29', 'visitors' => 259],
        ['date' => '2026-07-30', 'visitors' => 269],
        ['date' => '2026-07-31', 'visitors' => 259],
        ['date' => '2026-08-01', 'visitors' => 267],
    ];
@endphp

@section('title', 'Chart — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::chart /&gt;</p>
            <x-ui::heading :level="2">Chart</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Composable SVG charts with zero chart-library dependencies.</x-ui::text>
        </div>

        <div class="max-w-4xl space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Line chart</x-ui::text>
                <x-ui::chart :value="$data" class="aspect-[3/1] w-full">
                    <x-ui::chart.svg>
                        <x-ui::chart.line field="visitors" class="text-[var(--chart-3)]" />
                        <x-ui::chart.axis axis="x" field="date">
                            <x-ui::chart.axis.line />
                            <x-ui::chart.axis.tick />
                        </x-ui::chart.axis>
                        <x-ui::chart.axis axis="y">
                            <x-ui::chart.axis.grid />
                            <x-ui::chart.axis.tick />
                        </x-ui::chart.axis>
                        <x-ui::chart.cursor />
                    </x-ui::chart.svg>
                    <x-ui::chart.tooltip>
                        <x-ui::chart.tooltip.heading field="date" />
                        <x-ui::chart.tooltip.value field="visitors" label="Visitors" />
                    </x-ui::chart.tooltip>
                </x-ui::chart>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Sparkline</x-ui::text>
                <x-ui::chart :value="[15, 18, 16, 19, 22, 24, 21]" class="aspect-[3/1] w-32">
                    <x-ui::chart.svg gutter="0">
                        <x-ui::chart.line class="text-[var(--chart-4)]" />
                    </x-ui::chart.svg>
                </x-ui::chart>
            </div>
        </div>
    </div>
@endsection
