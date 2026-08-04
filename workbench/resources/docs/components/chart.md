Composable SVG charts with zero chart-library dependencies ([Flux chart](https://fluxui.dev/components/chart), [shadcn chart tokens](https://ui.shadcn.com/docs/components/chart)). Compose `chart.svg` with `line`, `area`, `bar`, `point`, `axis`, `cursor`, `tooltip`, `legend`, and `summary`. Reference series colors with `var(--chart-1)` through `var(--chart-5)` from owned `stencil.css`. `stencil:add chart` copies `chart.js`.

```blade
<x-ui::chart :value="$data" class="aspect-[3/1]">
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
```

<br>
