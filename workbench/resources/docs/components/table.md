Semantic data table ([shadcn Table](https://ui.shadcn.com/docs/components/table), [Flux table](https://fluxui.dev/components/table)).

```blade
<x-std::table>
    <x-std::table.caption>Recent invoices</x-std::table.caption>
    <x-std::table.header>
        <x-std::table.row>
            <x-std::table.head>Invoice</x-std::table.head>
            <x-std::table.head>Amount</x-std::table.head>
        </x-std::table.row>
    </x-std::table.header>
    <x-std::table.body>
        <x-std::table.row>
            <x-std::table.cell variant="strong">INV001</x-std::table.cell>
            <x-std::table.cell>$250.00</x-std::table.cell>
        </x-std::table.row>
    </x-std::table.body>
</x-std::table>
```

<br>
