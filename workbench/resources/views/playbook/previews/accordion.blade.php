@php
    $exclusive = (bool) ($state['exclusive'] ?? true);
    $bordered = (bool) ($state['bordered'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-xl">
    <x-std::accordion :exclusive="$exclusive" :bordered="$bordered" :transition="$transition">
        <x-std::accordion.item value="shipping" :expanded="true">
            <x-std::accordion.trigger>What are your shipping options?</x-std::accordion.trigger>
            <x-std::accordion.content>
                Standard (5–7 days), express (2–3 days), and overnight.
            </x-std::accordion.content>
        </x-std::accordion.item>
        <x-std::accordion.item heading="What is your return policy?">
            30-day money-back guarantee on unused items.
        </x-std::accordion.item>
        <x-std::accordion.item heading="Do you ship internationally?">
            Yes — rates are calculated at checkout.
        </x-std::accordion.item>
    </x-std::accordion>
</div>
