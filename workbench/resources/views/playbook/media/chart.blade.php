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

@section('title', 'Chart — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::chart /&gt;</p>
            <x-std::heading :level="2">Chart</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Composable SVG charts with zero chart-library dependencies.</x-std::text>
        </div>

        <div class="max-w-4xl space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Line chart</x-std::text>
                <x-std::chart :value="$data" class="aspect-[3/1] w-full">
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
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Sparkline</x-std::text>
                <x-std::chart :value="[15, 18, 16, 19, 22, 24, 21]" class="aspect-[3/1] w-32">
                    <x-std::chart.svg gutter="0">
                        <x-std::chart.line class="text-[var(--chart-4)]" />
                    </x-std::chart.svg>
                </x-std::chart>
            </div>
        </div>
    </div>
@endsection
