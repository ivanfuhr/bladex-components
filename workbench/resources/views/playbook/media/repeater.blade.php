@extends('workbench::playbook.media.layout')

@section('title', 'Repeater — Std Components')

@section('content')
    @php
        $value = [
            ['name' => 'Ada Lovelace', 'role' => 'Owner'],
            ['name' => 'Alan Turing', 'role' => 'Member'],
        ];
    @endphp

    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::repeater /&gt;</p>
            <x-std::heading :level="2">Repeater</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Dynamic Laravel array fields with add/remove rows and native form submission.
            </x-std::text>
        </div>

        <div class="space-y-3">
            <x-std::text size="sm" variant="subtle">Default</x-std::text>
            <x-std::repeater name="members" :value="$value" :min="1" class="w-full max-w-xl">
                <x-std::repeater.item>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <x-std::input data-repeater-field="name" placeholder="Name" />
                        <x-std::input data-repeater-field="role" placeholder="Role" />
                    </div>
                    <x-std::repeater.remove />
                </x-std::repeater.item>

                <x-std::repeater.add>Add member</x-std::repeater.add>
            </x-std::repeater>
        </div>
    </div>
@endsection
