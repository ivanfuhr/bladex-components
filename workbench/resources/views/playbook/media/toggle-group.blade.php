@extends('workbench::playbook.media.layout')

@section('title', 'Toggle Group — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::toggle-group /&gt;</p>
            <x-stencil::heading :level="2">Toggle Group</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Single or multiple selection among connected toggle items.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Single · outline</x-stencil::text>
                <x-stencil::toggle-group type="single" variant="outline" default-value="bold" aria-label="Text style">
                    <x-stencil::toggle-group.item value="bold">Bold</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="italic">Italic</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="underline">Underline</x-stencil::toggle-group.item>
                </x-stencil::toggle-group>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Multiple · spaced</x-stencil::text>
                <x-stencil::toggle-group
                    type="multiple"
                    variant="outline"
                    spacing="2"
                    :default-value="['bold']"
                    aria-label="Format"
                >
                    <x-stencil::toggle-group.item value="bold">Bold</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="italic">Italic</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="underline">Underline</x-stencil::toggle-group.item>
                </x-stencil::toggle-group>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Vertical</x-stencil::text>
                <x-stencil::toggle-group
                    orientation="vertical"
                    variant="outline"
                    spacing="2"
                    default-value="left"
                    aria-label="Align"
                >
                    <x-stencil::toggle-group.item value="left">Left</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="center">Center</x-stencil::toggle-group.item>
                    <x-stencil::toggle-group.item value="right">Right</x-stencil::toggle-group.item>
                </x-stencil::toggle-group>
            </div>
        </div>
    </div>
@endsection
