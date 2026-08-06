@extends('workbench::playbook.media.layout')

@section('title', 'Empty — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::empty /&gt;</p>
            <x-std::heading :level="2">Empty</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Composable empty state for lists, tables, and first-run screens.</x-std::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <x-std::empty class="border border-zinc-200 dark:border-zinc-800">
                <x-std::empty.header>
                    <x-std::empty.media variant="icon" icon="file" />
                    <x-std::empty.title>No projects yet</x-std::empty.title>
                    <x-std::empty.description>
                        You haven't created any projects yet. Get started by creating your first project.
                    </x-std::empty.description>
                </x-std::empty.header>
                <x-std::empty.content>
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <x-std::button variant="primary">Create project</x-std::button>
                        <x-std::button variant="outline">Import project</x-std::button>
                    </div>
                </x-std::empty.content>
            </x-std::empty>
        </div>
    </div>
@endsection
