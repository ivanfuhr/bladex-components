@extends('workbench::playbook.media.layout')

@section('title', 'Toggle Group — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::toggle-group /&gt;</p>
            <x-std::heading :level="2">Toggle Group</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Single or multiple selection among connected toggle items.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Single · outline</x-std::text>
                <x-std::toggle-group type="single" variant="outline" default-value="bold" aria-label="Text style">
                    <x-std::toggle-group.item value="bold">Bold</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="italic">Italic</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="underline">Underline</x-std::toggle-group.item>
                </x-std::toggle-group>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Multiple · spaced</x-std::text>
                <x-std::toggle-group
                    type="multiple"
                    variant="outline"
                    spacing="2"
                    :default-value="['bold']"
                    aria-label="Format"
                >
                    <x-std::toggle-group.item value="bold">Bold</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="italic">Italic</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="underline">Underline</x-std::toggle-group.item>
                </x-std::toggle-group>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Vertical</x-std::text>
                <x-std::toggle-group
                    orientation="vertical"
                    variant="outline"
                    spacing="2"
                    default-value="left"
                    aria-label="Align"
                >
                    <x-std::toggle-group.item value="left">Left</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="center">Center</x-std::toggle-group.item>
                    <x-std::toggle-group.item value="right">Right</x-std::toggle-group.item>
                </x-std::toggle-group>
            </div>
        </div>
    </div>
@endsection
