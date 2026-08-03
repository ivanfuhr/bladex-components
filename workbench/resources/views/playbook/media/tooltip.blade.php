@extends('workbench::playbook.media.layout')

@section('title', 'Tooltip — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::tooltip /&gt;</p>
            <x-ui::heading :level="2">Tooltip</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Hover and focus hints for controls.</x-ui::text>
        </div>

        <div class="flex flex-wrap items-end justify-center overflow-visible px-16 pt-12" style="gap: 6rem">
            <div class="relative inline-flex min-h-[5rem] items-end justify-center">
                <x-ui::tooltip side="top">
                    <x-ui::tooltip.trigger>
                        <x-ui::button variant="outline">Hover me</x-ui::button>
                    </x-ui::tooltip.trigger>
                    <x-ui::tooltip.content
                        data-state="open"
                        :hidden="false"
                        class="absolute bottom-full left-1/2 mb-2 block! -translate-x-1/2"
                        style="
                            position: absolute;
                            bottom: 100%;
                            left: 50%;
                            transform: translateX(-50%);
                            margin-bottom: 0.5rem;
                            display: block;
                        "
                    >
                        Add to library
                    </x-ui::tooltip.content>
                </x-ui::tooltip>
            </div>

            <div class="relative inline-flex min-h-[5rem] items-end justify-center">
                <x-ui::tooltip side="top">
                    <x-ui::tooltip.trigger>
                        <x-ui::button variant="primary" square>
                            <x-ui::icon name="plus" class="size-4" />
                        </x-ui::button>
                    </x-ui::tooltip.trigger>
                    <x-ui::tooltip.content
                        data-state="open"
                        :hidden="false"
                        class="absolute bottom-full left-1/2 mb-2 block! -translate-x-1/2"
                        style="
                            position: absolute;
                            bottom: 100%;
                            left: 50%;
                            transform: translateX(-50%);
                            margin-bottom: 0.5rem;
                            display: block;
                        "
                    >
                        Create project
                    </x-ui::tooltip.content>
                </x-ui::tooltip>
            </div>
        </div>
    </div>
@endsection
