@extends('workbench::playbook.media.layout')

@section('title', 'Switch — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::switch /&gt;</p>
            <x-std::heading :level="2">Switch</x-std::heading>
            <x-std::text size="sm" variant="subtle">Settings-style toggles with role="switch".</x-std::text>
        </div>

        <div class="flex max-w-md flex-col gap-8">
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">Default</x-std::text>
                <x-std::field name="n1" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-std::field.label>Notifications</x-std::field.label>
                    </div>
                    <x-std::switch name="n1" :checked="true" />
                </x-std::field>
            </div>
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">Small</x-std::text>
                <x-std::field name="n2" orientation="inline">
                    <div class="flex min-w-0 flex-1 flex-col gap-1">
                        <x-std::field.label>Notifications</x-std::field.label>
                    </div>
                    <x-std::switch name="n2" size="sm" :checked="true" />
                </x-std::field>
            </div>
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">Unchecked</x-std::text>
                <x-std::switch name="n3" />
            </div>
        </div>
    </div>
@endsection
