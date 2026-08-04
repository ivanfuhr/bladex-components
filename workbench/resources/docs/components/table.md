Semantic data table ([shadcn Table](https://ui.shadcn.com/docs/components/table), [Flux table](https://fluxui.dev/components/table)).

```blade
<x-ui::table>
    <x-ui::table.caption>Recent invoices</x-ui::table.caption>
    <x-ui::table.header>
        <x-ui::table.row>
            <x-ui::table.head>Invoice</x-ui::table.head>
            <x-ui::table.head>Amount</x-ui::table.head>
        </x-ui::table.row>
    </x-ui::table.header>
    <x-ui::table.body>
        <x-ui::table.row>
            <x-ui::table.cell variant="strong">INV001</x-ui::table.cell>
            <x-ui::table.cell>$250.00</x-ui::table.cell>
        </x-ui::table.row>
    </x-ui::table.body>
</x-ui::table>
```

<br>
