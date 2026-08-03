@extends('workbench::playbook.media.layout')

@section('title', 'Badge — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::badge /&gt;</p>
            <x-ui::heading :level="2">Badge</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Compact status labels with variants, colors, and dismiss.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Variants</x-ui::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui::badge>Secondary</x-ui::badge>
                    <x-ui::badge variant="default">Default</x-ui::badge>
                    <x-ui::badge variant="outline">Outline</x-ui::badge>
                    <x-ui::badge variant="destructive">Failed</x-ui::badge>
                    <x-ui::badge variant="ghost">Ghost</x-ui::badge>
                </div>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Colors · rounded · dismissible</x-ui::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui::badge color="lime" rounded>New</x-ui::badge>
                    <x-ui::badge color="violet" rounded>Beta</x-ui::badge>
                    <x-ui::badge color="blue">Info</x-ui::badge>
                    <x-ui::badge>
                        Admin
                        <x-ui::badge.close />
                    </x-ui::badge>
                </div>
            </div>
        </div>
    </div>
@endsection
