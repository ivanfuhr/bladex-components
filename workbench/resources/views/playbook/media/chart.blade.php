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
            <x-stencil::heading :level="2">Chart</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Composable SVG charts with zero chart-library dependencies.</x-stencil::text>
        </div>

        <div class="max-w-4xl space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Line chart</x-stencil::text>
                <x-stencil::chart :value="$data" class="aspect-[3/1] w-full">
                    <x-stencil::chart.svg>
                        <x-stencil::chart.line field="visitors" class="text-[var(--chart-3)]" />
                        <x-stencil::chart.axis axis="x" field="date">
                            <x-stencil::chart.axis.line />
                            <x-stencil::chart.axis.tick />
                        </x-stencil::chart.axis>
                        <x-stencil::chart.axis axis="y">
                            <x-stencil::chart.axis.grid />
                            <x-stencil::chart.axis.tick />
                        </x-stencil::chart.axis>
                        <x-stencil::chart.cursor />
                    </x-stencil::chart.svg>
                    <x-stencil::chart.tooltip>
                        <x-stencil::chart.tooltip.heading field="date" />
                        <x-stencil::chart.tooltip.value field="visitors" label="Visitors" />
                    </x-stencil::chart.tooltip>
                </x-stencil::chart>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Sparkline</x-stencil::text>
                <x-stencil::chart :value="[15, 18, 16, 19, 22, 24, 21]" class="aspect-[3/1] w-32">
                    <x-stencil::chart.svg gutter="0">
                        <x-stencil::chart.line class="text-[var(--chart-4)]" />
                    </x-stencil::chart.svg>
                </x-stencil::chart>
            </div>
        </div>
    </div>
@endsection
