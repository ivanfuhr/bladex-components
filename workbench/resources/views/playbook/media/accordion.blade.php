@extends('workbench::playbook.media.layout')

@section('title', 'Accordion — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::accordion /&gt;</p>
            <x-stencil::heading :level="2">Accordion</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Vertically stacked disclosures with exclusive or multiple open items.</x-stencil::text>
        </div>

        <div class="max-w-xl space-y-3">
            <x-stencil::text size="sm" variant="subtle">Exclusive · bordered</x-stencil::text>
            <x-stencil::accordion exclusive bordered>
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
    </div>
@endsection
