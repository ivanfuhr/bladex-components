@extends('workbench::playbook.media.layout')

@section('title', 'Button Group — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::button-group /&gt;</p>
            <x-ui::heading :level="2">Button Group</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Attached action buttons with shared borders, separators, and text.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Horizontal</x-ui::text>
                <x-ui::button-group aria-label="Document actions">
                    <x-ui::button variant="outline">Archive</x-ui::button>
                    <x-ui::button variant="outline">Report</x-ui::button>
                    <x-ui::button variant="outline">Snooze</x-ui::button>
                </x-ui::button-group>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Vertical · separator · text</x-ui::text>
                <div class="flex flex-wrap items-start gap-4">
                    <x-ui::button-group orientation="vertical" aria-label="Zoom">
                        <x-ui::button variant="outline" square>+</x-ui::button>
                        <x-ui::button variant="outline" square>−</x-ui::button>
                    </x-ui::button-group>

                    <x-ui::button-group aria-label="Clipboard">
                        <x-ui::button variant="outline">Copy</x-ui::button>
                        <x-ui::button-group.separator />
                        <x-ui::button variant="outline">Paste</x-ui::button>
                    </x-ui::button-group>

                    <x-ui::button-group>
                        <x-ui::button-group.text>https://</x-ui::button-group.text>
                        <x-ui::button variant="outline">Open</x-ui::button>
                    </x-ui::button-group>
                </div>
            </div>
        </div>
    </div>
@endsection
