@extends('workbench::playbook.media.layout')

@section('title', 'Button Group — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::button-group /&gt;</p>
            <x-std::heading :level="2">Button Group</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Attached action buttons with shared borders, separators, and text.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Horizontal</x-std::text>
                <x-std::button-group aria-label="Document actions">
                    <x-std::button variant="outline">Archive</x-std::button>
                    <x-std::button variant="outline">Report</x-std::button>
                    <x-std::button variant="outline">Snooze</x-std::button>
                </x-std::button-group>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Vertical · separator · text</x-std::text>
                <div class="flex flex-wrap items-start gap-4">
                    <x-std::button-group orientation="vertical" aria-label="Zoom">
                        <x-std::button variant="outline" square>+</x-std::button>
                        <x-std::button variant="outline" square>−</x-std::button>
                    </x-std::button-group>

                    <x-std::button-group aria-label="Clipboard">
                        <x-std::button variant="outline">Copy</x-std::button>
                        <x-std::button-group.separator />
                        <x-std::button variant="outline">Paste</x-std::button>
                    </x-std::button-group>

                    <x-std::button-group>
                        <x-std::button-group.text>https://</x-std::button-group.text>
                        <x-std::button variant="outline">Open</x-std::button>
                    </x-std::button-group>
                </div>
            </div>
        </div>
    </div>
@endsection
