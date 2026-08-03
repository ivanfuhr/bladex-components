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
        <x-ui::chart :value="$barData" label="Monthly revenue" class="aspect-[3/1] w-full">
            <x-ui::chart.svg gutter="24 16 40 56">
                <x-ui::chart.bar field="revenue" class="text-[var(--chart-3)]" width="70%" />
                <x-ui::chart.axis axis="x" field="month">
                    <x-ui::chart.axis.line />
                    <x-ui::chart.axis.tick />
                </x-ui::chart.axis>
                <x-ui::chart.axis axis="y" tick-prefix="$" :format="['maximumFractionDigits' => 0]">
                    <x-ui::chart.axis.grid />
                    <x-ui::chart.axis.tick />
                </x-ui::chart.axis>
                <x-ui::chart.cursor type="area" />
            </x-ui::chart.svg>
            <x-ui::chart.tooltip>
                <x-ui::chart.tooltip.heading field="month" />
                <x-ui::chart.tooltip.value field="revenue" label="Revenue" prefix="$" />
            </x-ui::chart.tooltip>
        </x-ui::chart>
    @elseif ($variant === 'area')
        <x-ui::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-ui::chart.svg>
                <x-ui::chart.line field="visitors" class="text-[var(--chart-3)]" curve="none" />
                <x-ui::chart.area field="visitors" class="text-[var(--chart-3)]/25" curve="none" />
                <x-ui::chart.axis axis="x" field="date">
                    <x-ui::chart.axis.tick />
                </x-ui::chart.axis>
                <x-ui::chart.axis axis="y">
                    <x-ui::chart.axis.grid />
                    <x-ui::chart.axis.tick />
                </x-ui::chart.axis>
            </x-ui::chart.svg>
        </x-ui::chart>
    @else
        <x-ui::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-ui::chart.svg>
                <x-ui::chart.line field="visitors" class="text-[var(--chart-3)]" />
                <x-ui::chart.point field="visitors" class="text-[var(--chart-3)]" />
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
    @endif
</div>
