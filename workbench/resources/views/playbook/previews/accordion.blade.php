@php
    $exclusive = (bool) ($state['exclusive'] ?? true);
    $bordered = (bool) ($state['bordered'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-xl">
    <x-ui::accordion :exclusive="$exclusive" :bordered="$bordered" :transition="$transition">
        <x-ui::accordion.item value="shipping" :expanded="true">
            <x-ui::accordion.trigger>What are your shipping options?</x-ui::accordion.trigger>
            <x-ui::accordion.content> Standard (5–7 days), express (2–3 days), and overnight. </x-ui::accordion.content>
        </x-ui::accordion.item>
        <x-ui::accordion.item heading="What is your return policy?">
            30-day money-back guarantee on unused items.
        </x-ui::accordion.item>
        <x-ui::accordion.item heading="Do you ship internationally?">
            Yes — rates are calculated at checkout.
        </x-ui::accordion.item>
    </x-ui::accordion>
</div>
