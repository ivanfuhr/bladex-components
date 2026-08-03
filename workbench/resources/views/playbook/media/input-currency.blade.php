@extends('workbench::playbook.media.layout')

@section('title', 'Input Currency — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::input.currency /&gt;</p>
            <x-ui::heading :level="2">Input Currency</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Locale-aware currency field with a decimal submit value.
            </x-ui::text>
        </div>

        <div class="max-w-sm space-y-3">
            <x-ui::input.currency
                name="amount"
                :value="1234.56"
                currency="BRL"
                locale="pt_BR"
                :precision="2"
                placeholder="0,00"
                class="w-full"
            />
        </div>
    </div>
@endsection
