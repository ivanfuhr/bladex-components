@extends('workbench::playbook.media.layout')

@section('title', 'Repeater — Stencil')

@section('content')
    @php
        $value = [
            ['name' => 'Ada Lovelace', 'role' => 'Owner'],
            ['name' => 'Alan Turing', 'role' => 'Member'],
        ];
    @endphp

    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::repeater /&gt;</p>
            <x-ui::heading :level="2">Repeater</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Dynamic Laravel array fields with add/remove rows and native form submission.
            </x-ui::text>
        </div>

        <div class="space-y-3">
            <x-ui::text size="sm" variant="subtle">Default</x-ui::text>
            <x-ui::repeater name="members" :value="$value" :min="1" class="w-full max-w-xl">
                <x-ui::repeater.item>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <x-ui::input data-repeater-field="name" placeholder="Name" />
                        <x-ui::input data-repeater-field="role" placeholder="Role" />
                    </div>
                    <x-ui::repeater.remove />
                </x-ui::repeater.item>

                <x-ui::repeater.add>Add member</x-ui::repeater.add>
            </x-ui::repeater>
        </div>
    </div>
@endsection
