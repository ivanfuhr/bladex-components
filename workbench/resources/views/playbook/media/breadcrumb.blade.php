@extends('workbench::playbook.media.layout')

@section('title', 'Breadcrumb — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::breadcrumb /&gt;</p>
            <x-stencil::heading :level="2">Breadcrumb</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Navigation trail for nested pages.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Chevron separators</x-stencil::text>
                <x-stencil::breadcrumb>
                    <x-stencil::breadcrumb.list>
                        <x-stencil::breadcrumb.item href="#">Home</x-stencil::breadcrumb.item>
                        <x-stencil::breadcrumb.separator />
                        <x-stencil::breadcrumb.item href="#">Settings</x-stencil::breadcrumb.item>
                        <x-stencil::breadcrumb.separator />
                        <x-stencil::breadcrumb.item>
                            <x-stencil::breadcrumb.page>Profile</x-stencil::breadcrumb.page>
                        </x-stencil::breadcrumb.item>
                    </x-stencil::breadcrumb.list>
                </x-stencil::breadcrumb>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Slash separators</x-stencil::text>
                <x-stencil::breadcrumb>
                    <x-stencil::breadcrumb.list>
                        <x-stencil::breadcrumb.item href="#">Docs</x-stencil::breadcrumb.item>
                        <x-stencil::breadcrumb.separator type="slash" />
                        <x-stencil::breadcrumb.item href="#">Components</x-stencil::breadcrumb.item>
                        <x-stencil::breadcrumb.separator type="slash" />
                        <x-stencil::breadcrumb.item>
                            <x-stencil::breadcrumb.page>Breadcrumb</x-stencil::breadcrumb.page>
                        </x-stencil::breadcrumb.item>
                    </x-stencil::breadcrumb.list>
                </x-stencil::breadcrumb>
            </div>
        </div>
    </div>
@endsection
