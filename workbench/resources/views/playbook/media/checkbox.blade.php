@extends('workbench::playbook.media.layout')

@section('title', 'Checkbox — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::checkbox /&gt;</p>
            <x-stencil::heading :level="2">Checkbox</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Native checkbox for forms and multi-select.</x-stencil::text>
        </div>

        <div class="flex flex-col gap-8 max-w-md">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default &amp; small, checked</x-stencil::text>
                <x-stencil::field name="a" orientation="inline">
                    <x-stencil::checkbox name="a" :checked="true" />
                    <x-stencil::field.label>Default size</x-stencil::field.label>
                </x-stencil::field>
                <x-stencil::field name="b" orientation="inline">
                    <x-stencil::checkbox name="b" size="sm" :checked="true" />
                    <x-stencil::field.label>Small</x-stencil::field.label>
                </x-stencil::field>
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Invalid &amp; disabled</x-stencil::text>
                <x-stencil::field orientation="inline">
                    <x-stencil::checkbox name="c" :invalid="true" />
                    <x-stencil::field.label>Invalid</x-stencil::field.label>
                </x-stencil::field>
                <x-stencil::field orientation="inline">
                    <x-stencil::checkbox name="d" disabled />
                    <x-stencil::field.label>Disabled</x-stencil::field.label>
                </x-stencil::field>
            </div>
        </div>
    </div>
@endsection
