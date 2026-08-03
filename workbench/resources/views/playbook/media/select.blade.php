@extends('workbench::playbook.media.layout')

@section('title', 'Select — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::select /&gt;</p>
            <x-ui::heading :level="2">Select</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Accessible listbox with groups, separator, and compound sub-components.</x-ui::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Default</x-ui::text>
                <x-ui::select name="industry" placeholder="Choose industry…" class="w-full">
                    <x-ui::select.group>
                        <x-ui::select.label>Creative</x-ui::select.label>
                        <x-ui::select.item value="photo">Photography</x-ui::select.item>
                        <x-ui::select.item value="design">Design services</x-ui::select.item>
                    </x-ui::select.group>
                    <x-ui::select.separator />
                    <x-ui::select.item value="web">Web development</x-ui::select.item>
                    <x-ui::select.item value="other">Other</x-ui::select.item>
                </x-ui::select>
            </div>
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Small · invalid · disabled</x-ui::text>
                <x-ui::select name="role" size="sm" placeholder="Select a role…" class="w-full">
                    <x-ui::select.item value="admin">Admin</x-ui::select.item>
                    <x-ui::select.item value="editor">Editor</x-ui::select.item>
                </x-ui::select>
                <x-ui::select name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-ui::select.item value="x">Option</x-ui::select.item>
                </x-ui::select>
                <x-ui::select name="off" placeholder="Disabled" disabled class="w-full">
                    <x-ui::select.item value="x">Option</x-ui::select.item>
                </x-ui::select>
            </div>
        </div>
    </div>
@endsection
