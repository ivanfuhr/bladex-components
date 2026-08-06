@extends('workbench::playbook.media.layout')

@section('title', 'Popover — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::popover /&gt;</p>
            <x-std::heading :level="2">Popover</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Anchored floating panel with keyboard dismiss and focus management.
            </x-std::text>
        </div>

        <div class="relative inline-block min-h-[12rem] min-w-[18rem]">
            <x-std::popover align="start" side="bottom">
                <x-std::popover.trigger>
                    <x-std::button variant="outline">Filters</x-std::button>
                </x-std::popover.trigger>
                <x-std::popover.content
                    :open="true"
                    class="absolute top-12 left-0 block! w-64 shadow-md!"
                    style="position: absolute; top: 3rem; left: 0; display: block"
                >
                    <div class="space-y-2">
                        <p class="text-sm font-medium">Quick filters</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Track, status, and owner.</p>
                    </div>
                </x-std::popover.content>
            </x-std::popover>
        </div>
    </div>
@endsection
