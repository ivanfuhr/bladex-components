@extends('workbench::playbook.media.layout')

@section('title', 'Combobox — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::combobox /&gt;</p>
            <x-ui::heading :level="2">Combobox</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Filterable autocomplete with typeahead list, empty state, and compound sub-components.</x-ui::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Default</x-ui::text>
                <x-ui::combobox name="framework" placeholder="Search frameworks…" class="w-full">
                    <x-ui::combobox.group>
                        <x-ui::combobox.label>PHP</x-ui::combobox.label>
                        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
                        <x-ui::combobox.item value="symfony">Symfony</x-ui::combobox.item>
                    </x-ui::combobox.group>
                    <x-ui::combobox.separator />
                    <x-ui::combobox.item value="react">React</x-ui::combobox.item>
                    <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
                </x-ui::combobox>
            </div>
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Small · invalid · disabled</x-ui::text>
                <x-ui::combobox name="lang" size="sm" placeholder="Find a language…" class="w-full">
                    <x-ui::combobox.item value="php">PHP</x-ui::combobox.item>
                    <x-ui::combobox.item value="js">JavaScript</x-ui::combobox.item>
                </x-ui::combobox>
                <x-ui::combobox name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
                </x-ui::combobox>
                <x-ui::combobox name="off" placeholder="Disabled" disabled class="w-full">
                    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
                </x-ui::combobox>
            </div>
        </div>
    </div>
@endsection
