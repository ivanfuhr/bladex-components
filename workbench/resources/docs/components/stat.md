Dashboard KPI card ([Mary UI Statistic](https://mary-ui.com/docs/components/statistic), [Filament Stats Overview](https://filamentphp.com/docs/5.x/widgets/stats-overview)). Label, value, optional description, trend, and icon — shortcut props or compound parts.

```blade
<x-ui::stat
    label="Open tickets"
    value="128"
    trend="+12.4%"
    trend-direction="up"
    description="vs last 7 days"
    icon="file"
/>

<x-ui::stat variant="muted">
    <div class="flex items-start justify-between gap-3">
        <div class="space-y-1">
            <x-ui::stat.label>Resolved</x-ui::stat.label>
            <x-ui::stat.value>86%</x-ui::stat.value>
        </div>
        <x-ui::stat.icon>
            <x-ui::icon name="check" class="size-4" />
        </x-ui::stat.icon>
    </div>
    <x-ui::stat.description>This week</x-ui::stat.description>
</x-ui::stat>
```

<br>
