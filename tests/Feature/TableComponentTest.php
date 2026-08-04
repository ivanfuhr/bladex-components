<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a table with caption header body and cells', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::table>
            <x-ui::table.caption>Invoices</x-ui::table.caption>
            <x-ui::table.header>
                <x-ui::table.row>
                    <x-ui::table.head>Invoice</x-ui::table.head>
                    <x-ui::table.head sortable sorted direction="desc">Amount</x-ui::table.head>
                </x-ui::table.row>
            </x-ui::table.header>
            <x-ui::table.body>
                <x-ui::table.row>
                    <x-ui::table.cell variant="strong">INV001</x-ui::table.cell>
                    <x-ui::table.cell>$250.00</x-ui::table.cell>
                </x-ui::table.row>
            </x-ui::table.body>
        </x-ui::table>
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
