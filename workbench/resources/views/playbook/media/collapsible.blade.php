@extends('workbench::playbook.media.layout')

@section('title', 'Collapsible — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::collapsible /&gt;</p>
            <x-stencil::heading :level="2">Collapsible</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Single-panel expand and collapse.</x-stencil::text>
        </div>

        <div class="max-w-md space-y-6">
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-stencil::text size="sm" variant="subtle">Open</x-stencil::text>
                <x-stencil::collapsible :open="true">
                    <x-stencil::collapsible.trigger>Toggle details</x-stencil::collapsible.trigger>
                    <x-stencil::collapsible.content class="mt-2">
                        Extra product information lives here — dimensions, materials, and care instructions.
                    </x-stencil::collapsible.content>
                </x-stencil::collapsible>
            </div>
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-stencil::text size="sm" variant="subtle">Closed</x-stencil::text>
                <x-stencil::collapsible>
                    <x-stencil::collapsible.trigger>Show more</x-stencil::collapsible.trigger>
                    <x-stencil::collapsible.content class="mt-2">Hidden until opened.</x-stencil::collapsible.content>
                </x-stencil::collapsible>
            </div>
        </div>
    </div>
@endsection
