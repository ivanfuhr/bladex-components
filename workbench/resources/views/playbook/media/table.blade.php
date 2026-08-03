@extends('workbench::playbook.media.layout')

@section('title', 'Table — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::table /&gt;</p>
            <x-ui::heading :level="2">Table</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Semantic data table with caption, header, body, and footer.</x-ui::text>
        </div>

        <div class="max-w-2xl rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-ui::table>
                <x-ui::table.caption>Recent invoices</x-ui::table.caption>
                <x-ui::table.header>
                    <x-ui::table.row>
                        <x-ui::table.head>Invoice</x-ui::table.head>
                        <x-ui::table.head>Status</x-ui::table.head>
                        <x-ui::table.head>Method</x-ui::table.head>
                        <x-ui::table.head class="text-right">Amount</x-ui::table.head>
                    </x-ui::table.row>
                </x-ui::table.header>
                <x-ui::table.body>
                    <x-ui::table.row>
                        <x-ui::table.cell variant="strong">INV001</x-ui::table.cell>
                        <x-ui::table.cell>
                            <x-ui::badge color="green" rounded>Paid</x-ui::badge>
                        </x-ui::table.cell>
                        <x-ui::table.cell>Credit card</x-ui::table.cell>
                        <x-ui::table.cell class="text-right">$250.00</x-ui::table.cell>
                    </x-ui::table.row>
                    <x-ui::table.row>
                        <x-ui::table.cell variant="strong">INV002</x-ui::table.cell>
                        <x-ui::table.cell>
                            <x-ui::badge color="amber" rounded>Pending</x-ui::badge>
                        </x-ui::table.cell>
                        <x-ui::table.cell>PayPal</x-ui::table.cell>
                        <x-ui::table.cell class="text-right">$150.00</x-ui::table.cell>
                    </x-ui::table.row>
                    <x-ui::table.row>
                        <x-ui::table.cell variant="strong">INV003</x-ui::table.cell>
                        <x-ui::table.cell>
                            <x-ui::badge color="green" rounded>Paid</x-ui::badge>
                        </x-ui::table.cell>
                        <x-ui::table.cell>Bank transfer</x-ui::table.cell>
                        <x-ui::table.cell class="text-right">$350.00</x-ui::table.cell>
                    </x-ui::table.row>
                </x-ui::table.body>
            </x-ui::table>
        </div>
    </div>
@endsection
