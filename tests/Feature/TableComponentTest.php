<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a table with caption header body and cells', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::table>
            <x-stencil::table.caption>Invoices</x-stencil::table.caption>
            <x-stencil::table.header>
                <x-stencil::table.row>
                    <x-stencil::table.head>Invoice</x-stencil::table.head>
                    <x-stencil::table.head sortable sorted direction="desc">Amount</x-stencil::table.head>
                </x-stencil::table.row>
            </x-stencil::table.header>
            <x-stencil::table.body>
                <x-stencil::table.row>
                    <x-stencil::table.cell variant="strong">INV001</x-stencil::table.cell>
                    <x-stencil::table.cell>$250.00</x-stencil::table.cell>
                </x-stencil::table.row>
            </x-stencil::table.body>
        </x-stencil::table>
    BLADE);

    expect($html)
        ->toContain('data-table')
        ->toContain('<table')
        ->toContain('Invoices')
        ->toContain('data-table-head')
        ->toContain('aria-sort="descending"')
        ->toContain('INV001')
        ->toContain('data-variant="strong"')
        ->toContain('$250.00');
});
