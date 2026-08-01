@extends('workbench::playbook.media.layout')

@section('title', 'Badge — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::badge /&gt;</p>
            <x-stencil::heading :level="2">Badge</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Compact status labels with variants, colors, and dismiss.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Variants</x-stencil::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-stencil::badge>Secondary</x-stencil::badge>
                    <x-stencil::badge variant="default">Default</x-stencil::badge>
                    <x-stencil::badge variant="outline">Outline</x-stencil::badge>
                    <x-stencil::badge variant="destructive">Failed</x-stencil::badge>
                    <x-stencil::badge variant="ghost">Ghost</x-stencil::badge>
                </div>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Colors · rounded · dismissible</x-stencil::text>
                <div class="flex flex-wrap items-center gap-2">
                    <x-stencil::badge color="lime" rounded>New</x-stencil::badge>
                    <x-stencil::badge color="violet" rounded>Beta</x-stencil::badge>
                    <x-stencil::badge color="blue">Info</x-stencil::badge>
                    <x-stencil::badge>
                        Admin
                        <x-stencil::badge.close />
                    </x-stencil::badge>
                </div>
            </div>
        </div>
    </div>
@endsection
