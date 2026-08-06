@extends('workbench::playbook.media.layout')

@section('title', 'Checkbox — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::checkbox /&gt;</p>
            <x-std::heading :level="2">Checkbox</x-std::heading>
            <x-std::text size="sm" variant="subtle">Native checkbox for forms and multi-select.</x-std::text>
        </div>

        <div class="flex max-w-md flex-col gap-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default &amp; small, checked</x-std::text>
                <x-std::field name="a" orientation="inline">
                    <x-std::checkbox name="a" :checked="true" />
                    <x-std::field.label>Default size</x-std::field.label>
                </x-std::field>
                <x-std::field name="b" orientation="inline">
                    <x-std::checkbox name="b" size="sm" :checked="true" />
                    <x-std::field.label>Small</x-std::field.label>
                </x-std::field>
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Invalid &amp; disabled</x-std::text>
                <x-std::field orientation="inline">
                    <x-std::checkbox name="c" :invalid="true" />
                    <x-std::field.label>Invalid</x-std::field.label>
                </x-std::field>
                <x-std::field orientation="inline">
                    <x-std::checkbox name="d" disabled />
                    <x-std::field.label>Disabled</x-std::field.label>
                </x-std::field>
            </div>
        </div>
    </div>
@endsection
