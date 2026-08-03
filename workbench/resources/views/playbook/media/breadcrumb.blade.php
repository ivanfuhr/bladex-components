@extends('workbench::playbook.media.layout')

@section('title', 'Breadcrumb — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::breadcrumb /&gt;</p>
            <x-ui::heading :level="2">Breadcrumb</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Navigation trail for nested pages.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Chevron separators</x-ui::text>
                <x-ui::breadcrumb>
                    <x-ui::breadcrumb.list>
                        <x-ui::breadcrumb.item href="#">Home</x-ui::breadcrumb.item>
                        <x-ui::breadcrumb.separator />
                        <x-ui::breadcrumb.item href="#">Settings</x-ui::breadcrumb.item>
                        <x-ui::breadcrumb.separator />
                        <x-ui::breadcrumb.item>
                            <x-ui::breadcrumb.page>Profile</x-ui::breadcrumb.page>
                        </x-ui::breadcrumb.item>
                    </x-ui::breadcrumb.list>
                </x-ui::breadcrumb>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Slash separators</x-ui::text>
                <x-ui::breadcrumb>
                    <x-ui::breadcrumb.list>
                        <x-ui::breadcrumb.item href="#">Docs</x-ui::breadcrumb.item>
                        <x-ui::breadcrumb.separator type="slash" />
                        <x-ui::breadcrumb.item href="#">Components</x-ui::breadcrumb.item>
                        <x-ui::breadcrumb.separator type="slash" />
                        <x-ui::breadcrumb.item>
                            <x-ui::breadcrumb.page>Breadcrumb</x-ui::breadcrumb.page>
                        </x-ui::breadcrumb.item>
                    </x-ui::breadcrumb.list>
                </x-ui::breadcrumb>
            </div>
        </div>
    </div>
@endsection
