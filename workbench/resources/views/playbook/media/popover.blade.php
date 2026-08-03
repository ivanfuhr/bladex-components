@extends('workbench::playbook.media.layout')

@section('title', 'Popover — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::popover /&gt;</p>
            <x-ui::heading :level="2">Popover</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Anchored floating panel with keyboard dismiss and focus management.
            </x-ui::text>
        </div>

        <div class="relative inline-block min-h-[12rem] min-w-[18rem]">
            <x-ui::popover align="start" side="bottom">
                <x-ui::popover.trigger>
                    <x-ui::button variant="outline">Filters</x-ui::button>
                </x-ui::popover.trigger>
                <x-ui::popover.content
                    :open="true"
                    class="absolute top-12 left-0 block! w-64 shadow-md!"
                    style="position: absolute; top: 3rem; left: 0; display: block"
                >
                    <div class="space-y-2">
                        <p class="text-sm font-medium">Quick filters</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Track, status, and owner.</p>
                    </div>
                </x-ui::popover.content>
            </x-ui::popover>
        </div>
    </div>
@endsection
