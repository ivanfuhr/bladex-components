@extends('workbench::playbook.media.layout')

@section('title', 'Separator — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::separator /&gt;</p>
            <x-stencil::heading :level="2">Separator</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Horizontal or vertical divider.</x-stencil::text>
        </div>

        <div class="max-w-lg space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Horizontal</x-stencil::text>
                <x-stencil::text size="sm">Account settings</x-stencil::text>
                <x-stencil::separator />
                <x-stencil::text size="sm" variant="subtle">Manage your workspace preferences below.</x-stencil::text>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Vertical</x-stencil::text>
                <div class="flex h-8 items-center gap-3 text-sm">
                    <span>Blog</span>
                    <x-stencil::separator orientation="vertical" :decorative="false" />
                    <span>Docs</span>
                    <x-stencil::separator orientation="vertical" :decorative="false" />
                    <span>Source</span>
                </div>
            </div>
        </div>
    </div>
@endsection
