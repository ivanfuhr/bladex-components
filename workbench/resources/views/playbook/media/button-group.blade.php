@extends('workbench::playbook.media.layout')

@section('title', 'Button Group — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::button-group /&gt;</p>
            <x-stencil::heading :level="2">Button Group</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Attached action buttons with shared borders, separators, and text.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Horizontal</x-stencil::text>
                <x-stencil::button-group aria-label="Document actions">
                    <x-stencil::button variant="outline">Archive</x-stencil::button>
                    <x-stencil::button variant="outline">Report</x-stencil::button>
                    <x-stencil::button variant="outline">Snooze</x-stencil::button>
                </x-stencil::button-group>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Vertical · separator · text</x-stencil::text>
                <div class="flex flex-wrap items-start gap-4">
                    <x-stencil::button-group orientation="vertical" aria-label="Zoom">
                        <x-stencil::button variant="outline" square>+</x-stencil::button>
                        <x-stencil::button variant="outline" square>−</x-stencil::button>
                    </x-stencil::button-group>

                    <x-stencil::button-group aria-label="Clipboard">
                        <x-stencil::button variant="outline">Copy</x-stencil::button>
                        <x-stencil::button-group.separator />
                        <x-stencil::button variant="outline">Paste</x-stencil::button>
                    </x-stencil::button-group>

                    <x-stencil::button-group>
                        <x-stencil::button-group.text>https://</x-stencil::button-group.text>
                        <x-stencil::button variant="outline">Open</x-stencil::button>
                    </x-stencil::button-group>
                </div>
            </div>
        </div>
    </div>
@endsection
