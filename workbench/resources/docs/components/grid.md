Responsive column layout with container-query breakpoints by default ([Filament Grid](https://filamentphp.com/docs/3.x/forms/layout/grid)). Scalar breakpoint props (`sm`, `md`, `lg`, `xl`, `2xl`) and `grid.item` for full-width rows — no PHP arrays.

```blade
<x-ui::grid md="3" gap="4">
    <x-ui::stat label="Registrations" value="248" />
    <x-ui::stat label="Revenue" value="R$ 46.8k" />
    <x-ui::stat label="Check-in rate" value="64%" />
</x-ui::grid>

<x-ui::grid sm="2" gap="5">
    <x-ui::field name="title">…</x-ui::field>
    <x-ui::field name="slug">…</x-ui::field>
    <x-ui::grid.item span="full">
        <x-ui::field name="kickoff_at">…</x-ui::field>
    </x-ui::grid.item>
</x-ui::grid>

<x-ui::grid :cols="3" />
<x-ui::grid md="3" :container="false" />
```

<br>
