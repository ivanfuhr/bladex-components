@extends('workbench::playbook.media.layout')

@section('title', 'Combobox — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::combobox /&gt;</p>
            <x-stencil::heading :level="2">Combobox</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Filterable autocomplete with typeahead list, empty state, and compound sub-components.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::combobox name="framework" placeholder="Search frameworks…" class="w-full">
                    <x-stencil::combobox.group>
                        <x-stencil::combobox.label>PHP</x-stencil::combobox.label>
                        <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
                        <x-stencil::combobox.item value="symfony">Symfony</x-stencil::combobox.item>
                    </x-stencil::combobox.group>
                    <x-stencil::combobox.separator />
                    <x-stencil::combobox.item value="react">React</x-stencil::combobox.item>
                    <x-stencil::combobox.item value="vue">Vue</x-stencil::combobox.item>
                </x-stencil::combobox>
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Small · invalid · disabled</x-stencil::text>
                <x-stencil::combobox name="lang" size="sm" placeholder="Find a language…" class="w-full">
                    <x-stencil::combobox.item value="php">PHP</x-stencil::combobox.item>
                    <x-stencil::combobox.item value="js">JavaScript</x-stencil::combobox.item>
                </x-stencil::combobox>
                <x-stencil::combobox name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-stencil::combobox.item value="x">Option</x-stencil::combobox.item>
                </x-stencil::combobox>
                <x-stencil::combobox name="off" placeholder="Disabled" disabled class="w-full">
                    <x-stencil::combobox.item value="x">Option</x-stencil::combobox.item>
                </x-stencil::combobox>
            </div>
        </div>
    </div>
@endsection
