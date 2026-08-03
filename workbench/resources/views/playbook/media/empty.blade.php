@extends('workbench::playbook.media.layout')

@section('title', 'Empty — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::empty /&gt;</p>
            <x-ui::heading :level="2">Empty</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Composable empty state for lists, tables, and first-run screens.</x-ui::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <x-ui::empty class="border border-zinc-200 dark:border-zinc-800">
                <x-ui::empty.header>
                    <x-ui::empty.media variant="icon" icon="file" />
                    <x-ui::empty.title>No projects yet</x-ui::empty.title>
                    <x-ui::empty.description>
                        You haven't created any projects yet. Get started by creating your first project.
                    </x-ui::empty.description>
                </x-ui::empty.header>
                <x-ui::empty.content>
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <x-ui::button variant="primary">Create project</x-ui::button>
                        <x-ui::button variant="outline">Import project</x-ui::button>
                    </div>
                </x-ui::empty.content>
            </x-ui::empty>
        </div>
    </div>
@endsection
