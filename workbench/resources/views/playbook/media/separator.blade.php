@extends('workbench::playbook.media.layout')

@section('title', 'Separator — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::separator /&gt;</p>
            <x-ui::heading :level="2">Separator</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Horizontal or vertical divider.</x-ui::text>
        </div>

        <div class="max-w-lg space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Horizontal</x-ui::text>
                <x-ui::text size="sm">Account settings</x-ui::text>
                <x-ui::separator />
                <x-ui::text size="sm" variant="subtle">Manage your workspace preferences below.</x-ui::text>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Vertical</x-ui::text>
                <div class="flex h-8 items-center gap-3 text-sm">
                    <span>Blog</span>
                    <x-ui::separator orientation="vertical" :decorative="false" />
                    <span>Docs</span>
                    <x-ui::separator orientation="vertical" :decorative="false" />
                    <span>Source</span>
                </div>
            </div>
        </div>
    </div>
@endsection
