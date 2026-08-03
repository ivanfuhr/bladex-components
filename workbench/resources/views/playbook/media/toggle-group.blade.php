@extends('workbench::playbook.media.layout')

@section('title', 'Toggle Group — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::toggle-group /&gt;</p>
            <x-ui::heading :level="2">Toggle Group</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Single or multiple selection among connected toggle items.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Single · outline</x-ui::text>
                <x-ui::toggle-group type="single" variant="outline" default-value="bold" aria-label="Text style">
                    <x-ui::toggle-group.item value="bold">Bold</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="italic">Italic</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="underline">Underline</x-ui::toggle-group.item>
                </x-ui::toggle-group>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Multiple · spaced</x-ui::text>
                <x-ui::toggle-group
                    type="multiple"
                    variant="outline"
                    spacing="2"
                    :default-value="['bold']"
                    aria-label="Format"
                >
                    <x-ui::toggle-group.item value="bold">Bold</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="italic">Italic</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="underline">Underline</x-ui::toggle-group.item>
                </x-ui::toggle-group>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Vertical</x-ui::text>
                <x-ui::toggle-group
                    orientation="vertical"
                    variant="outline"
                    spacing="2"
                    default-value="left"
                    aria-label="Align"
                >
                    <x-ui::toggle-group.item value="left">Left</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="center">Center</x-ui::toggle-group.item>
                    <x-ui::toggle-group.item value="right">Right</x-ui::toggle-group.item>
                </x-ui::toggle-group>
            </div>
        </div>
    </div>
@endsection
