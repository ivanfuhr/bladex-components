@php
    $showCaption = (bool) ($state['show_caption'] ?? true);
    $showBadges = (bool) ($state['show_badges'] ?? true);
@endphp

<div class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-ui::table>
        @if ($showCaption)
            <x-ui::table.caption>Recent invoices</x-ui::table.caption>
        @endif
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
                    @if ($showBadges)
                        <x-ui::badge color="green" rounded>Paid</x-ui::badge>
                    @else
                        Paid
                    @endif
                </x-ui::table.cell>
                <x-ui::table.cell>Credit card</x-ui::table.cell>
                <x-ui::table.cell class="text-right">$250.00</x-ui::table.cell>
            </x-ui::table.row>
            <x-ui::table.row>
                <x-ui::table.cell variant="strong">INV002</x-ui::table.cell>
                <x-ui::table.cell>
                    @if ($showBadges)
                        <x-ui::badge color="amber" rounded>Pending</x-ui::badge>
                    @else
                        Pending
                    @endif
                </x-ui::table.cell>
                <x-ui::table.cell>PayPal</x-ui::table.cell>
                <x-ui::table.cell class="text-right">$150.00</x-ui::table.cell>
            </x-ui::table.row>
        </x-ui::table.body>
    </x-ui::table>
</div>
