@extends('workbench::playbook.media.layout')

@section('title', 'Tooltip — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::tooltip /&gt;</p>
            <x-std::heading :level="2">Tooltip</x-std::heading>
            <x-std::text size="sm" variant="subtle">Hover and focus hints for controls.</x-std::text>
        </div>

        <div class="flex flex-wrap items-end justify-center overflow-visible px-16 pt-12" style="gap: 6rem">
            <div class="relative inline-flex min-h-[5rem] items-end justify-center">
                <x-std::tooltip side="top">
                    <x-std::tooltip.trigger>
                        <x-std::button variant="outline">Hover me</x-std::button>
                    </x-std::tooltip.trigger>
                    <x-std::tooltip.content
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
                    </x-std::tooltip.content>
                </x-std::tooltip>
            </div>

            <div class="relative inline-flex min-h-[5rem] items-end justify-center">
                <x-std::tooltip side="top">
                    <x-std::tooltip.trigger>
                        <x-std::button variant="primary" square>
                            <x-std::icon name="plus" class="size-4" />
                        </x-std::button>
                    </x-std::tooltip.trigger>
                    <x-std::tooltip.content
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
                    </x-std::tooltip.content>
                </x-std::tooltip>
            </div>
        </div>
    </div>
@endsection
