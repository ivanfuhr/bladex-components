@php
    $variant = (string) ($state['variant'] ?? 'line');

    $lineData = [
        ['date' => '2026-07-28', 'visitors' => 241],
        ['date' => '2026-07-29', 'visitors' => 259],
        ['date' => '2026-07-30', 'visitors' => 269],
        ['date' => '2026-07-31', 'visitors' => 259],
        ['date' => '2026-08-01', 'visitors' => 267],
    ];

    $barData = [
        ['month' => 'Jan', 'revenue' => 4200],
        ['month' => 'Feb', 'revenue' => 3800],
        ['month' => 'Mar', 'revenue' => 5100],
        ['month' => 'Apr', 'revenue' => 4600],
        ['month' => 'May', 'revenue' => 5400],
    ];
@endphp

<div class="w-full max-w-3xl">
    @if ($variant === 'bar')
        <x-stencil::chart :value="$barData" label="Monthly revenue" class="aspect-[3/1] w-full">
            <x-stencil::chart.svg gutter="24 16 40 56">
                <x-stencil::chart.bar field="revenue" class="text-[var(--chart-3)]" width="70%" />
                <x-stencil::chart.axis axis="x" field="month">
                    <x-stencil::chart.axis.line />
                    <x-stencil::chart.axis.tick />
                </x-stencil::chart.axis>
                <x-stencil::chart.axis axis="y" tick-prefix="$" :format="['maximumFractionDigits' => 0]">
                    <x-stencil::chart.axis.grid />
                    <x-stencil::chart.axis.tick />
                </x-stencil::chart.axis>
                <x-stencil::chart.cursor type="area" />
            </x-stencil::chart.svg>
            <x-stencil::chart.tooltip>
                <x-stencil::chart.tooltip.heading field="month" />
                <x-stencil::chart.tooltip.value field="revenue" label="Revenue" prefix="$" />
            </x-stencil::chart.tooltip>
        </x-stencil::chart>
    @elseif ($variant === 'area')
        <x-stencil::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-stencil::chart.svg>
                <x-stencil::chart.line field="visitors" class="text-[var(--chart-3)]" curve="none" />
                <x-stencil::chart.area field="visitors" class="text-[var(--chart-3)]/25" curve="none" />
                <x-stencil::chart.axis axis="x" field="date">
                    <x-stencil::chart.axis.tick />
                </x-stencil::chart.axis>
                <x-stencil::chart.axis axis="y">
                    <x-stencil::chart.axis.grid />
                    <x-stencil::chart.axis.tick />
                </x-stencil::chart.axis>
            </x-stencil::chart.svg>
        </x-stencil::chart>
    @else
        <x-stencil::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-stencil::chart.svg>
                <x-stencil::chart.line field="visitors" class="text-[var(--chart-3)]" />
                <x-stencil::chart.point field="visitors" class="text-[var(--chart-3)]" />
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
    @endif
</div>
