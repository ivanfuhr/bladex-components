@extends('workbench::playbook.media.layout')

@section('title', 'Popover — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::popover /&gt;</p>
            <x-stencil::heading :level="2">Popover</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Anchored floating panel with keyboard dismiss and focus management.
            </x-stencil::text>
        </div>

        <div class="relative inline-block min-h-[12rem] min-w-[18rem]">
            <x-stencil::popover align="start" side="bottom">
                <x-stencil::popover.trigger>
                    <x-stencil::button variant="outline">Filters</x-stencil::button>
                </x-stencil::popover.trigger>
                <x-stencil::popover.content
                    :open="true"
                    class="absolute top-12 left-0 block! w-64 shadow-md!"
                    style="position: absolute; top: 3rem; left: 0; display: block"
                >
                    <div class="space-y-2">
                        <p class="text-sm font-medium">Quick filters</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Track, status, and owner.</p>
                    </div>
                </x-stencil::popover.content>
            </x-stencil::popover>
        </div>
    </div>
@endsection
