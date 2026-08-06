@extends('workbench::playbook.media.layout')

@section('title', 'Breadcrumb — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::breadcrumb /&gt;</p>
            <x-std::heading :level="2">Breadcrumb</x-std::heading>
            <x-std::text size="sm" variant="subtle">Navigation trail for nested pages.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Chevron separators</x-std::text>
                <x-std::breadcrumb>
                    <x-std::breadcrumb.list>
                        <x-std::breadcrumb.item href="#">Home</x-std::breadcrumb.item>
                        <x-std::breadcrumb.separator />
                        <x-std::breadcrumb.item href="#">Settings</x-std::breadcrumb.item>
                        <x-std::breadcrumb.separator />
                        <x-std::breadcrumb.item>
                            <x-std::breadcrumb.page>Profile</x-std::breadcrumb.page>
                        </x-std::breadcrumb.item>
                    </x-std::breadcrumb.list>
                </x-std::breadcrumb>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Slash separators</x-std::text>
                <x-std::breadcrumb>
                    <x-std::breadcrumb.list>
                        <x-std::breadcrumb.item href="#">Docs</x-std::breadcrumb.item>
                        <x-std::breadcrumb.separator type="slash" />
                        <x-std::breadcrumb.item href="#">Components</x-std::breadcrumb.item>
                        <x-std::breadcrumb.separator type="slash" />
                        <x-std::breadcrumb.item>
                            <x-std::breadcrumb.page>Breadcrumb</x-std::breadcrumb.page>
                        </x-std::breadcrumb.item>
                    </x-std::breadcrumb.list>
                </x-std::breadcrumb>
            </div>
        </div>
    </div>
@endsection
