Composable field shell: label, control, description, and Laravel errors — inspired by [shadcn Field](https://ui.shadcn.com/docs/components/radix/field) and [Flux field](https://fluxui.dev/components/field). Use `orientation="inline"` for checkbox/switch rows.

```blade
<x-std::field name="email">
    <x-std::field.label>Email</x-std::field.label>
    <x-std::input name="email" type="email" placeholder="you@example.com" />
    <x-std::field.description>Used for invoices and receipts.</x-std::field.description>
</x-std::field>

<x-std::field name="username" :invalid="true">
    <x-std::field.label>Username</x-std::field.label>
    <x-std::input name="username" value="taken" />
    <x-std::field.message variant="error">That username is already taken.</x-std::field.message>
</x-std::field>
```

<br>
