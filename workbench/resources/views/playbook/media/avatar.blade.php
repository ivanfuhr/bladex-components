@extends('workbench::playbook.media.layout')

@section('title', 'Avatar — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::avatar /&gt;</p>
            <x-stencil::heading :level="2">Avatar</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">User image or initials, including stacked groups.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Sizes · circle · colors</x-stencil::text>
                <div class="flex flex-wrap items-end gap-3">
                    <x-stencil::avatar name="Ada Lovelace" size="xs" circle color="violet" />
                    <x-stencil::avatar name="Ada Lovelace" size="sm" circle color="blue" />
                    <x-stencil::avatar name="Ada Lovelace" circle color="green" />
                    <x-stencil::avatar name="Ada Lovelace" size="lg" circle color="amber" />
                    <x-stencil::avatar name="Ada Lovelace" size="xl" circle color="rose" />
                    <x-stencil::avatar name="Caleb Porzio" size="lg" color="indigo" />
                </div>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Group</x-stencil::text>
                <x-stencil::avatar.group>
                    <x-stencil::avatar name="One Person" circle color="violet" />
                    <x-stencil::avatar name="Two Person" circle color="blue" />
                    <x-stencil::avatar name="Three Person" circle color="green" />
                    <x-stencil::avatar name="Four Person" circle color="amber" />
                </x-stencil::avatar.group>
            </div>
        </div>
    </div>
@endsection
