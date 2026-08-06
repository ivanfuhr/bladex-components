@extends('workbench::playbook.media.layout')

@section('title', 'Accordion — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::accordion /&gt;</p>
            <x-std::heading :level="2">Accordion</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Vertically stacked disclosures with exclusive or multiple open items.</x-std::text>
        </div>

        <div class="max-w-xl space-y-3">
            <x-std::text size="sm" variant="subtle">Exclusive · bordered</x-std::text>
            <x-std::accordion exclusive bordered>
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
    </div>
@endsection
