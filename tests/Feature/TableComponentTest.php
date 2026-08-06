<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a table with caption header body and cells', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::table>
            <x-std::table.caption>Invoices</x-std::table.caption>
            <x-std::table.header>
                <x-std::table.row>
                    <x-std::table.head>Invoice</x-std::table.head>
                    <x-std::table.head sortable sorted direction="desc">Amount</x-std::table.head>
                </x-std::table.row>
            </x-std::table.header>
            <x-std::table.body>
                <x-std::table.row>
                    <x-std::table.cell variant="strong">INV001</x-std::table.cell>
                    <x-std::table.cell>$250.00</x-std::table.cell>
                </x-std::table.row>
            </x-std::table.body>
        </x-std::table>
    BLADE);

    expect($html)
        ->toContain('data-table')
        ->toContain('<table')
        ->toContain('Invoices')
        ->toContain('data-table-head')
        ->toContain('scope="col"')
        ->toContain('aria-sort="descending"')
        ->toContain('INV001')
        ->toContain('data-variant="strong"')
        ->toContain('$250.00');
});
