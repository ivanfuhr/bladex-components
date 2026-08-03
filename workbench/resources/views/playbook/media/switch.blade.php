@extends('workbench::playbook.media.layout')

@section('title', 'Switch — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::switch /&gt;</p>
            <x-ui::heading :level="2">Switch</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Settings-style toggles with role="switch".</x-ui::text>
        </div>

        <div class="flex max-w-md flex-col gap-8">
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">Default</x-ui::text>
                <x-ui::field name="n1" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-ui::field.label>Notifications</x-ui::field.label>
                    </div>
                    <x-ui::switch name="n1" :checked="true" />
                </x-ui::field>
            </div>
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">Small</x-ui::text>
                <x-ui::field name="n2" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-ui::field.label>Notifications</x-ui::field.label>
                    </div>
                    <x-ui::switch name="n2" size="sm" :checked="true" />
                </x-ui::field>
            </div>
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">Unchecked</x-ui::text>
                <x-ui::switch name="n3" />
            </div>
        </div>
    </div>
@endsection
