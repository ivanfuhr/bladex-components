@extends('workbench::playbook.media.layout')

@section('title', 'Table — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::table /&gt;</p>
            <x-std::heading :level="2">Table</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Semantic data table with caption, header, body, and footer.</x-std::text>
        </div>

        <div class="max-w-2xl rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-std::table>
                <x-std::table.caption>Recent invoices</x-std::table.caption>
                <x-std::table.header>
                    <x-std::table.row>
                        <x-std::table.head>Invoice</x-std::table.head>
                        <x-std::table.head>Status</x-std::table.head>
                        <x-std::table.head>Method</x-std::table.head>
                        <x-std::table.head class="text-right">Amount</x-std::table.head>
                    </x-std::table.row>
                </x-std::table.header>
                <x-std::table.body>
                    <x-std::table.row>
                        <x-std::table.cell variant="strong">INV001</x-std::table.cell>
                        <x-std::table.cell>
                            <x-std::badge color="green" rounded>Paid</x-std::badge>
                        </x-std::table.cell>
                        <x-std::table.cell>Credit card</x-std::table.cell>
                        <x-std::table.cell class="text-right">$250.00</x-std::table.cell>
                    </x-std::table.row>
                    <x-std::table.row>
                        <x-std::table.cell variant="strong">INV002</x-std::table.cell>
                        <x-std::table.cell>
                            <x-std::badge color="amber" rounded>Pending</x-std::badge>
                        </x-std::table.cell>
                        <x-std::table.cell>PayPal</x-std::table.cell>
                        <x-std::table.cell class="text-right">$150.00</x-std::table.cell>
                    </x-std::table.row>
                    <x-std::table.row>
                        <x-std::table.cell variant="strong">INV003</x-std::table.cell>
                        <x-std::table.cell>
                            <x-std::badge color="green" rounded>Paid</x-std::badge>
                        </x-std::table.cell>
                        <x-std::table.cell>Bank transfer</x-std::table.cell>
                        <x-std::table.cell class="text-right">$350.00</x-std::table.cell>
                    </x-std::table.row>
                </x-std::table.body>
            </x-std::table>
        </div>
    </div>
@endsection
