@extends('workbench::playbook.media.layout')

@section('title', 'Badge — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::badge /&gt;</p>
            <x-std::heading :level="2">Badge</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Compact status labels with variants, colors, and dismiss.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Variants</x-std::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-std::badge>Secondary</x-std::badge>
                    <x-std::badge variant="default">Default</x-std::badge>
                    <x-std::badge variant="outline">Outline</x-std::badge>
                    <x-std::badge variant="destructive">Failed</x-std::badge>
                    <x-std::badge variant="ghost">Ghost</x-std::badge>
                </div>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Colors · rounded · dismissible</x-std::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-std::badge color="lime" rounded>New</x-std::badge>
                    <x-std::badge color="violet" rounded>Beta</x-std::badge>
                    <x-std::badge color="blue">Info</x-std::badge>
                    <x-std::badge>
                        Admin
                        <x-std::badge.close />
                    </x-std::badge>
                </div>
            </div>
        </div>
    </div>
@endsection
