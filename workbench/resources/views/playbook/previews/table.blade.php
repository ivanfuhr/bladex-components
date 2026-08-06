@php
    $showCaption = (bool) ($state['show_caption'] ?? true);
    $showBadges = (bool) ($state['show_badges'] ?? true);
@endphp

<div class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-std::table>
        @if ($showCaption)
            <x-std::table.caption>Recent invoices</x-std::table.caption>
        @endif
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
                    @if ($showBadges)
                        <x-std::badge color="green" rounded>Paid</x-std::badge>
                    @else
                        Paid
                    @endif
                </x-std::table.cell>
                <x-std::table.cell>Credit card</x-std::table.cell>
                <x-std::table.cell class="text-right">$250.00</x-std::table.cell>
            </x-std::table.row>
            <x-std::table.row>
                <x-std::table.cell variant="strong">INV002</x-std::table.cell>
                <x-std::table.cell>
                    @if ($showBadges)
                        <x-std::badge color="amber" rounded>Pending</x-std::badge>
                    @else
                        Pending
                    @endif
                </x-std::table.cell>
                <x-std::table.cell>PayPal</x-std::table.cell>
                <x-std::table.cell class="text-right">$150.00</x-std::table.cell>
            </x-std::table.row>
        </x-std::table.body>
    </x-std::table>
</div>
