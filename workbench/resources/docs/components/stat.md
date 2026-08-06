Dashboard KPI card ([Mary UI Statistic](https://mary-ui.com/docs/components/statistic), [Filament Stats Overview](https://filamentphp.com/docs/5.x/widgets/stats-overview)). Label, value, optional description, trend, and icon — shortcut props or compound parts.

```blade
<x-std::stat
    label="Open tickets"
    value="128"
    trend="+12.4%"
    trend-direction="up"
    description="vs last 7 days"
    icon="file"
/>

<x-std::stat variant="muted">
    <div class="flex items-start justify-between gap-3">
        <div class="space-y-1">
            <x-std::stat.label>Resolved</x-std::stat.label>
            <x-std::stat.value>86%</x-std::stat.value>
        </div>
        <x-std::stat.icon>
            <x-std::icon name="check" class="size-4" />
        </x-std::stat.icon>
    </div>
    <x-std::stat.description>This week</x-std::stat.description>
</x-std::stat>
```

<br>
