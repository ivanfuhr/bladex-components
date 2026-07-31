@extends('workbench::playbook.media.layout')

@section('title', 'Select — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::select /&gt;</p>
            <x-stencil::heading :level="2">Select</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Accessible listbox with groups, separator, and compound sub-components.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::select name="industry" placeholder="Choose industry…" class="w-full">
                    <x-stencil::select.group>
                        <x-stencil::select.label>Creative</x-stencil::select.label>
                        <x-stencil::select.item value="photo">Photography</x-stencil::select.item>
                        <x-stencil::select.item value="design">Design services</x-stencil::select.item>
                    </x-stencil::select.group>
                    <x-stencil::select.separator />
                    <x-stencil::select.item value="web">Web development</x-stencil::select.item>
                    <x-stencil::select.item value="other">Other</x-stencil::select.item>
                </x-stencil::select>
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Small · invalid · disabled</x-stencil::text>
                <x-stencil::select name="role" size="sm" placeholder="Select a role…" class="w-full">
                    <x-stencil::select.item value="admin">Admin</x-stencil::select.item>
                    <x-stencil::select.item value="editor">Editor</x-stencil::select.item>
                </x-stencil::select>
                <x-stencil::select name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-stencil::select.item value="x">Option</x-stencil::select.item>
                </x-stencil::select>
                <x-stencil::select name="off" placeholder="Disabled" disabled class="w-full">
                    <x-stencil::select.item value="x">Option</x-stencil::select.item>
                </x-stencil::select>
            </div>
        </div>
    </div>
@endsection
