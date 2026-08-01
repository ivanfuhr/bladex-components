@extends('workbench::playbook.media.layout')

@section('title', 'Empty — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::empty /&gt;</p>
            <x-stencil::heading :level="2">Empty</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Composable empty state for lists, tables, and first-run screens.</x-stencil::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <x-stencil::empty class="border border-zinc-200 dark:border-zinc-800">
                <x-stencil::empty.header>
                    <x-stencil::empty.media variant="icon" icon="file" />
                    <x-stencil::empty.title>No projects yet</x-stencil::empty.title>
                    <x-stencil::empty.description>
                        You haven't created any projects yet. Get started by creating your first project.
                    </x-stencil::empty.description>
                </x-stencil::empty.header>
                <x-stencil::empty.content>
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <x-stencil::button variant="primary">Create project</x-stencil::button>
                        <x-stencil::button variant="outline">Import project</x-stencil::button>
                    </div>
                </x-stencil::empty.content>
            </x-stencil::empty>
        </div>
    </div>
@endsection
