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
        <x-std::chart :value="$barData" label="Monthly revenue" class="aspect-[3/1] w-full">
            <x-std::chart.svg gutter="24 16 40 56">
                <x-std::chart.bar field="revenue" class="text-[var(--chart-3)]" width="70%" />
                <x-std::chart.axis axis="x" field="month">
                    <x-std::chart.axis.line />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.axis axis="y" tick-prefix="$" :format="['maximumFractionDigits' => 0]">
                    <x-std::chart.axis.grid />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.cursor type="area" />
            </x-std::chart.svg>
            <x-std::chart.tooltip>
                <x-std::chart.tooltip.heading field="month" />
                <x-std::chart.tooltip.value field="revenue" label="Revenue" prefix="$" />
            </x-std::chart.tooltip>
        </x-std::chart>
    @elseif ($variant === 'area')
        <x-std::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-std::chart.svg>
                <x-std::chart.line field="visitors" class="text-[var(--chart-3)]" curve="none" />
                <x-std::chart.area field="visitors" class="text-[var(--chart-3)]/25" curve="none" />
                <x-std::chart.axis axis="x" field="date">
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
                <x-std::chart.axis axis="y">
                    <x-std::chart.axis.grid />
                    <x-std::chart.axis.tick />
                </x-std::chart.axis>
            </x-std::chart.svg>
        </x-std::chart>
    @else
        <x-std::chart :value="$lineData" label="Daily visitors" class="aspect-[3/1] w-full">
            <x-std::chart.svg>
                <x-std::chart.line field="visitors" class="text-[var(--chart-3)]" />
                <x-std::chart.point field="visitors" class="text-[var(--chart-3)]" />
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
    @endif
</div>
