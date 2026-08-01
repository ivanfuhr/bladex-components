@extends('workbench::playbook.media.layout')

@section('title', 'Table — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::table /&gt;</p>
            <x-stencil::heading :level="2">Table</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Semantic data table with caption, header, body, and footer.</x-stencil::text>
        </div>

        <div class="max-w-2xl rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-stencil::table>
                <x-stencil::table.caption>Recent invoices</x-stencil::table.caption>
                <x-stencil::table.header>
                    <x-stencil::table.row>
                        <x-stencil::table.head>Invoice</x-stencil::table.head>
                        <x-stencil::table.head>Status</x-stencil::table.head>
                        <x-stencil::table.head>Method</x-stencil::table.head>
                        <x-stencil::table.head class="text-right">Amount</x-stencil::table.head>
                    </x-stencil::table.row>
                </x-stencil::table.header>
                <x-stencil::table.body>
                    <x-stencil::table.row>
                        <x-stencil::table.cell variant="strong">INV001</x-stencil::table.cell>
                        <x-stencil::table.cell>
                            <x-stencil::badge color="green" rounded>Paid</x-stencil::badge>
                        </x-stencil::table.cell>
                        <x-stencil::table.cell>Credit card</x-stencil::table.cell>
                        <x-stencil::table.cell class="text-right">$250.00</x-stencil::table.cell>
                    </x-stencil::table.row>
                    <x-stencil::table.row>
                        <x-stencil::table.cell variant="strong">INV002</x-stencil::table.cell>
                        <x-stencil::table.cell>
                            <x-stencil::badge color="amber" rounded>Pending</x-stencil::badge>
                        </x-stencil::table.cell>
                        <x-stencil::table.cell>PayPal</x-stencil::table.cell>
                        <x-stencil::table.cell class="text-right">$150.00</x-stencil::table.cell>
                    </x-stencil::table.row>
                    <x-stencil::table.row>
                        <x-stencil::table.cell variant="strong">INV003</x-stencil::table.cell>
                        <x-stencil::table.cell>
                            <x-stencil::badge color="green" rounded>Paid</x-stencil::badge>
                        </x-stencil::table.cell>
                        <x-stencil::table.cell>Bank transfer</x-stencil::table.cell>
                        <x-stencil::table.cell class="text-right">$350.00</x-stencil::table.cell>
                    </x-stencil::table.row>
                </x-stencil::table.body>
            </x-stencil::table>
        </div>
    </div>
@endsection
