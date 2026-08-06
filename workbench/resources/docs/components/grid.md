Responsive column layout with container-query breakpoints by default ([Filament Grid](https://filamentphp.com/docs/3.x/forms/layout/grid)). Scalar breakpoint props (`sm`, `md`, `lg`, `xl`, `2xl`) and `grid.item` for full-width rows — no PHP arrays.

```blade
<x-std::grid md="3" gap="4">
    <x-std::stat label="Registrations" value="248" />
    <x-std::stat label="Revenue" value="R$ 46.8k" />
    <x-std::stat label="Check-in rate" value="64%" />
</x-std::grid>

<x-std::grid sm="2" gap="5">
    <x-std::field name="title">…</x-std::field>
    <x-std::field name="slug">…</x-std::field>
    <x-std::grid.item span="full">
        <x-std::field name="kickoff_at">…</x-std::field>
    </x-std::grid.item>
</x-std::grid>

<x-std::grid :cols="3" />
<x-std::grid md="3" :container="false" />
```

<br>
