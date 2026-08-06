@extends('workbench::playbook.media.layout')

@section('title', 'Collapsible — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::collapsible /&gt;</p>
            <x-std::heading :level="2">Collapsible</x-std::heading>
            <x-std::text size="sm" variant="subtle">Single-panel expand and collapse.</x-std::text>
        </div>

        <div class="max-w-md space-y-6">
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-std::text size="sm" variant="subtle">Open</x-std::text>
                <x-std::collapsible :open="true">
                    <x-std::collapsible.trigger>Toggle details</x-std::collapsible.trigger>
                    <x-std::collapsible.content class="mt-2">
                        Extra product information lives here — dimensions, materials, and care instructions.
                    </x-std::collapsible.content>
                </x-std::collapsible>
            </div>
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-std::text size="sm" variant="subtle">Closed</x-std::text>
                <x-std::collapsible>
                    <x-std::collapsible.trigger>Show more</x-std::collapsible.trigger>
                    <x-std::collapsible.content class="mt-2">Hidden until opened.</x-std::collapsible.content>
                </x-std::collapsible>
            </div>
        </div>
    </div>
@endsection
