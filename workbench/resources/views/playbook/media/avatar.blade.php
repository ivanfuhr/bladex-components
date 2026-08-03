@extends('workbench::playbook.media.layout')

@section('title', 'Avatar — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::avatar /&gt;</p>
            <x-ui::heading :level="2">Avatar</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">User image or initials, including stacked groups.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Sizes · circle · colors</x-ui::text>
                <div class="flex flex-wrap items-end gap-3">
                    <x-ui::avatar name="Ada Lovelace" size="xs" circle color="violet" />
                    <x-ui::avatar name="Ada Lovelace" size="sm" circle color="blue" />
                    <x-ui::avatar name="Ada Lovelace" circle color="green" />
                    <x-ui::avatar name="Ada Lovelace" size="lg" circle color="amber" />
                    <x-ui::avatar name="Ada Lovelace" size="xl" circle color="rose" />
                    <x-ui::avatar name="Caleb Porzio" size="lg" color="indigo" />
                </div>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Group</x-ui::text>
                <x-ui::avatar.group>
                    <x-ui::avatar name="One Person" circle color="violet" />
                    <x-ui::avatar name="Two Person" circle color="blue" />
                    <x-ui::avatar name="Three Person" circle color="green" />
                    <x-ui::avatar name="Four Person" circle color="amber" />
                </x-ui::avatar.group>
            </div>
        </div>
    </div>
@endsection
