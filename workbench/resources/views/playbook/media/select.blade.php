@extends('workbench::playbook.media.layout')

@section('title', 'Select — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::select /&gt;</p>
            <x-std::heading :level="2">Select</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Accessible listbox with groups, separator, and compound sub-components.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default</x-std::text>
                <x-std::select name="industry" placeholder="Choose industry…" class="w-full">
                    <x-std::select.group>
                        <x-std::select.label>Creative</x-std::select.label>
                        <x-std::select.item value="photo">Photography</x-std::select.item>
                        <x-std::select.item value="design">Design services</x-std::select.item>
                    </x-std::select.group>
                    <x-std::select.separator />
                    <x-std::select.item value="web">Web development</x-std::select.item>
                    <x-std::select.item value="other">Other</x-std::select.item>
                </x-std::select>
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Small · invalid · disabled</x-std::text>
                <x-std::select name="role" size="sm" placeholder="Select a role…" class="w-full">
                    <x-std::select.item value="admin">Admin</x-std::select.item>
                    <x-std::select.item value="editor">Editor</x-std::select.item>
                </x-std::select>
                <x-std::select name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-std::select.item value="x">Option</x-std::select.item>
                </x-std::select>
                <x-std::select name="off" placeholder="Disabled" disabled class="w-full">
                    <x-std::select.item value="x">Option</x-std::select.item>
                </x-std::select>
            </div>
        </div>
    </div>
@endsection
