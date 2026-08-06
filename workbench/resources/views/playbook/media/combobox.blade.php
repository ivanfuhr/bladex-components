@extends('workbench::playbook.media.layout')

@section('title', 'Combobox — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::combobox /&gt;</p>
            <x-std::heading :level="2">Combobox</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Filterable autocomplete with typeahead list, empty state, and compound sub-components.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default</x-std::text>
                <x-std::combobox name="framework" placeholder="Search frameworks…" class="w-full">
                    <x-std::combobox.group>
                        <x-std::combobox.label>PHP</x-std::combobox.label>
                        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
                        <x-std::combobox.item value="symfony">Symfony</x-std::combobox.item>
                    </x-std::combobox.group>
                    <x-std::combobox.separator />
                    <x-std::combobox.item value="react">React</x-std::combobox.item>
                    <x-std::combobox.item value="vue">Vue</x-std::combobox.item>
                </x-std::combobox>
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Small · invalid · disabled</x-std::text>
                <x-std::combobox name="lang" size="sm" placeholder="Find a language…" class="w-full">
                    <x-std::combobox.item value="php">PHP</x-std::combobox.item>
                    <x-std::combobox.item value="js">JavaScript</x-std::combobox.item>
                </x-std::combobox>
                <x-std::combobox name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-std::combobox.item value="x">Option</x-std::combobox.item>
                </x-std::combobox>
                <x-std::combobox name="off" placeholder="Disabled" disabled class="w-full">
                    <x-std::combobox.item value="x">Option</x-std::combobox.item>
                </x-std::combobox>
            </div>
        </div>
    </div>
@endsection
