Composable SVG charts with zero chart-library dependencies ([Flux chart](https://fluxui.dev/components/chart), [shadcn chart tokens](https://ui.shadcn.com/docs/components/chart)). Compose `chart.svg` with `line`, `area`, `bar`, `point`, `axis`, `cursor`, `tooltip`, `legend`, and `summary`. Reference series colors with `var(--chart-1)` through `var(--chart-5)` from package `std-components.css`. Included in `@stdScripts`.

```blade
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
```

<br>
