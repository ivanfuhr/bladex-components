@extends('workbench::playbook.media.layout')

@section('title', 'Checkbox — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::checkbox /&gt;</p>
            <x-ui::heading :level="2">Checkbox</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Native checkbox for forms and multi-select.</x-ui::text>
        </div>

        <div class="flex max-w-md flex-col gap-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Default &amp; small, checked</x-ui::text>
                <x-ui::field name="a" orientation="inline">
                    <x-ui::checkbox name="a" :checked="true" />
                    <x-ui::field.label>Default size</x-ui::field.label>
                </x-ui::field>
                <x-ui::field name="b" orientation="inline">
                    <x-ui::checkbox name="b" size="sm" :checked="true" />
                    <x-ui::field.label>Small</x-ui::field.label>
                </x-ui::field>
            </div>
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Invalid &amp; disabled</x-ui::text>
                <x-ui::field orientation="inline">
                    <x-ui::checkbox name="c" :invalid="true" />
                    <x-ui::field.label>Invalid</x-ui::field.label>
                </x-ui::field>
                <x-ui::field orientation="inline">
                    <x-ui::checkbox name="d" disabled />
                    <x-ui::field.label>Disabled</x-ui::field.label>
                </x-ui::field>
            </div>
        </div>
    </div>
@endsection
