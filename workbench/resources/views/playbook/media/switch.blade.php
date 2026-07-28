@extends('workbench::playbook.media.layout')

@section('title', 'Switch — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::switch /&gt;</p>
            <x-stencil::heading :level="2">Switch</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Settings-style toggles with role="switch".</x-stencil::text>
        </div>

        <div class="flex max-w-md flex-col gap-8">
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::field name="n1" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-stencil::field.label>Notifications</x-stencil::field.label>
                    </div>
                    <x-stencil::switch name="n1" :checked="true" />
                </x-stencil::field>
            </div>
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">Small</x-stencil::text>
                <x-stencil::field name="n2" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-stencil::field.label>Notifications</x-stencil::field.label>
                    </div>
                    <x-stencil::switch name="n2" size="sm" :checked="true" />
                </x-stencil::field>
            </div>
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">Unchecked</x-stencil::text>
                <x-stencil::switch name="n3" />
            </div>
        </div>
    </div>
@endsection
