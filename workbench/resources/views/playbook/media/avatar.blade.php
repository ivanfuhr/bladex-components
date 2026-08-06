@extends('workbench::playbook.media.layout')

@section('title', 'Avatar — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::avatar /&gt;</p>
            <x-std::heading :level="2">Avatar</x-std::heading>
            <x-std::text size="sm" variant="subtle">User image or initials, including stacked groups.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Sizes · circle · colors</x-std::text>
                <div class="flex flex-wrap items-end gap-3">
                    <x-std::avatar name="Ada Lovelace" size="xs" circle color="violet" />
                    <x-std::avatar name="Ada Lovelace" size="sm" circle color="blue" />
                    <x-std::avatar name="Ada Lovelace" circle color="green" />
                    <x-std::avatar name="Ada Lovelace" size="lg" circle color="amber" />
                    <x-std::avatar name="Ada Lovelace" size="xl" circle color="rose" />
                    <x-std::avatar name="Caleb Porzio" size="lg" color="indigo" />
                </div>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Group</x-std::text>
                <x-std::avatar.group>
                    <x-std::avatar name="One Person" circle color="violet" />
                    <x-std::avatar name="Two Person" circle color="blue" />
                    <x-std::avatar name="Three Person" circle color="green" />
                    <x-std::avatar name="Four Person" circle color="amber" />
                </x-std::avatar.group>
            </div>
        </div>
    </div>
@endsection
