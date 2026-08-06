@extends('workbench::playbook.media.layout')

@section('title', 'Separator — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::separator /&gt;</p>
            <x-std::heading :level="2">Separator</x-std::heading>
            <x-std::text size="sm" variant="subtle">Horizontal or vertical divider.</x-std::text>
        </div>

        <div class="max-w-lg space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Horizontal</x-std::text>
                <x-std::text size="sm">Account settings</x-std::text>
                <x-std::separator />
                <x-std::text size="sm" variant="subtle">Manage your workspace preferences below.</x-std::text>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Vertical</x-std::text>
                <div class="flex h-8 items-center gap-3 text-sm">
                    <span>Blog</span>
                    <x-std::separator orientation="vertical" :decorative="false" />
                    <span>Docs</span>
                    <x-std::separator orientation="vertical" :decorative="false" />
                    <span>Source</span>
                </div>
            </div>
        </div>
    </div>
@endsection
