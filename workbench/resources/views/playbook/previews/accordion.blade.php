@php
    $exclusive = (bool) ($state['exclusive'] ?? true);
    $bordered = (bool) ($state['bordered'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-xl">
    <x-stencil::accordion :exclusive="$exclusive" :bordered="$bordered" :transition="$transition">
        <x-stencil::accordion.item value="shipping" :expanded="true">
            <x-stencil::accordion.trigger>What are your shipping options?</x-stencil::accordion.trigger>
            <x-stencil::accordion.content>
                Standard (5–7 days), express (2–3 days), and overnight.
            </x-stencil::accordion.content>
        </x-stencil::accordion.item>
        <x-stencil::accordion.item heading="What is your return policy?">
            30-day money-back guarantee on unused items.
        </x-stencil::accordion.item>
        <x-stencil::accordion.item heading="Do you ship internationally?">
            Yes — rates are calculated at checkout.
        </x-stencil::accordion.item>
    </x-stencil::accordion>
</div>
