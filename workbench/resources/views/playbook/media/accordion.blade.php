@extends('workbench::playbook.media.layout')

@section('title', 'Accordion — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::accordion /&gt;</p>
            <x-ui::heading :level="2">Accordion</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Vertically stacked disclosures with exclusive or multiple open items.</x-ui::text>
        </div>

        <div class="max-w-xl space-y-3">
            <x-ui::text size="sm" variant="subtle">Exclusive · bordered</x-ui::text>
            <x-ui::accordion exclusive bordered>
                <x-ui::accordion.item value="shipping" :expanded="true">
                    <x-ui::accordion.trigger>What are your shipping options?</x-ui::accordion.trigger>
                    <x-ui::accordion.content>
                        Standard (5–7 days), express (2–3 days), and overnight.
                    </x-ui::accordion.content>
                </x-ui::accordion.item>
                <x-ui::accordion.item heading="What is your return policy?">
                    30-day money-back guarantee on unused items.
                </x-ui::accordion.item>
                <x-ui::accordion.item heading="Do you ship internationally?">
                    Yes — rates are calculated at checkout.
                </x-ui::accordion.item>
            </x-ui::accordion>
        </div>
    </div>
@endsection
