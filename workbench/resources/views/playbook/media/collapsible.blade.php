@extends('workbench::playbook.media.layout')

@section('title', 'Collapsible — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::collapsible /&gt;</p>
            <x-ui::heading :level="2">Collapsible</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Single-panel expand and collapse.</x-ui::text>
        </div>

        <div class="max-w-md space-y-6">
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-ui::text size="sm" variant="subtle">Open</x-ui::text>
                <x-ui::collapsible :open="true">
                    <x-ui::collapsible.trigger>Toggle details</x-ui::collapsible.trigger>
                    <x-ui::collapsible.content class="mt-2">
                        Extra product information lives here — dimensions, materials, and care instructions.
                    </x-ui::collapsible.content>
                </x-ui::collapsible>
            </div>
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-ui::text size="sm" variant="subtle">Closed</x-ui::text>
                <x-ui::collapsible>
                    <x-ui::collapsible.trigger>Show more</x-ui::collapsible.trigger>
                    <x-ui::collapsible.content class="mt-2">Hidden until opened.</x-ui::collapsible.content>
                </x-ui::collapsible>
            </div>
        </div>
    </div>
@endsection
