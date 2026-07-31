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
            <x-stencil::heading :level="2">Repeater</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Dynamic Laravel array fields with add/remove rows and native form submission.
            </x-stencil::text>
        </div>

        <div class="space-y-3">
            <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
            <x-stencil::repeater name="members" :value="$value" :min="1" class="w-full max-w-xl">
                <x-stencil::repeater.item>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <x-stencil::input data-repeater-field="name" placeholder="Name" />
                        <x-stencil::input data-repeater-field="role" placeholder="Role" />
                    </div>
                    <x-stencil::repeater.remove />
                </x-stencil::repeater.item>

                <x-stencil::repeater.add>Add member</x-stencil::repeater.add>
            </x-stencil::repeater>
        </div>
    </div>
@endsection
