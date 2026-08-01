@extends('workbench::playbook.media.layout')

@section('title', 'Tooltip — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::tooltip /&gt;</p>
            <x-stencil::heading :level="2">Tooltip</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Hover and focus hints for controls.</x-stencil::text>
        </div>

        <div class="flex flex-wrap items-end gap-10 pt-8">
            <div class="relative inline-flex min-h-[4.5rem] items-end justify-center px-2">
                <x-stencil::tooltip side="top">
                    <x-stencil::tooltip.trigger>
                        <x-stencil::button variant="outline">Hover me</x-stencil::button>
                    </x-stencil::tooltip.trigger>
                    <x-stencil::tooltip.content
                        data-state="open"
                        :hidden="false"
                        class="absolute bottom-full left-1/2 mb-2 -translate-x-1/2 block!"
                        style="position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 0.5rem; display: block;"
                    >
                        Add to library
                    </x-stencil::tooltip.content>
                </x-stencil::tooltip>
            </div>

            <div class="relative inline-flex min-h-[4.5rem] items-end justify-center px-2">
                <x-stencil::tooltip side="top">
                    <x-stencil::tooltip.trigger>
                        <x-stencil::button variant="primary" square>
                            <x-stencil::icon name="plus" class="size-4" />
                        </x-stencil::button>
                    </x-stencil::tooltip.trigger>
                    <x-stencil::tooltip.content
                        data-state="open"
                        :hidden="false"
                        class="absolute bottom-full left-1/2 mb-2 -translate-x-1/2 block!"
                        style="position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 0.5rem; display: block;"
                    >
                        Create project
                    </x-stencil::tooltip.content>
                </x-stencil::tooltip>
            </div>
        </div>
    </div>
@endsection
