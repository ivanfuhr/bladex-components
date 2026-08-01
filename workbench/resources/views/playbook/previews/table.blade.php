@php
    $showCaption = (bool) ($state['show_caption'] ?? true);
    $showBadges = (bool) ($state['show_badges'] ?? true);
@endphp

<div class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-stencil::table>
        @if ($showCaption)
            <x-stencil::table.caption>Recent invoices</x-stencil::table.caption>
        @endif
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
                    @if ($showBadges)
                        <x-stencil::badge color="green" rounded>Paid</x-stencil::badge>
                    @else
                        Paid
                    @endif
                </x-stencil::table.cell>
                <x-stencil::table.cell>Credit card</x-stencil::table.cell>
                <x-stencil::table.cell class="text-right">$250.00</x-stencil::table.cell>
            </x-stencil::table.row>
            <x-stencil::table.row>
                <x-stencil::table.cell variant="strong">INV002</x-stencil::table.cell>
                <x-stencil::table.cell>
                    @if ($showBadges)
                        <x-stencil::badge color="amber" rounded>Pending</x-stencil::badge>
                    @else
                        Pending
                    @endif
                </x-stencil::table.cell>
                <x-stencil::table.cell>PayPal</x-stencil::table.cell>
                <x-stencil::table.cell class="text-right">$150.00</x-stencil::table.cell>
            </x-stencil::table.row>
        </x-stencil::table.body>
    </x-stencil::table>
</div>
