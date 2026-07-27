@extends('workbench::playbook.media.layout')

@section('title', 'Select — BladeX')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::select /&gt;</p>
            <x-bladex-components::heading :level="2">Select</x-bladex-components::heading>
            <x-bladex-components::text size="sm" variant="subtle">Accessible listbox with groups, separator, and compound sub-components.</x-bladex-components::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">Default</x-bladex-components::text>
                <x-bladex-components::select name="industry" placeholder="Choose industry…" class="w-full">
                    <x-bladex-components::select.group>
                        <x-bladex-components::select.label>Creative</x-bladex-components::select.label>
                        <x-bladex-components::select.item value="photo">Photography</x-bladex-components::select.item>
                        <x-bladex-components::select.item value="design">Design services</x-bladex-components::select.item>
                    </x-bladex-components::select.group>
                    <x-bladex-components::select.separator />
                    <x-bladex-components::select.item value="web">Web development</x-bladex-components::select.item>
                    <x-bladex-components::select.item value="other">Other</x-bladex-components::select.item>
                </x-bladex-components::select>
            </div>
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">Small · invalid · disabled</x-bladex-components::text>
                <x-bladex-components::select name="role" size="sm" placeholder="Select a role…" class="w-full">
                    <x-bladex-components::select.item value="admin">Admin</x-bladex-components::select.item>
                    <x-bladex-components::select.item value="editor">Editor</x-bladex-components::select.item>
                </x-bladex-components::select>
                <x-bladex-components::select name="bad" placeholder="Invalid" invalid class="w-full">
                    <x-bladex-components::select.item value="x">Option</x-bladex-components::select.item>
                </x-bladex-components::select>
                <x-bladex-components::select name="off" placeholder="Disabled" disabled class="w-full">
                    <x-bladex-components::select.item value="x">Option</x-bladex-components::select.item>
                </x-bladex-components::select>
            </div>
        </div>
    </div>
@endsection
