@extends('workbench::playbook.media.layout')

@section('title', 'Stepper — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::stepper /&gt;</p>
            <x-std::heading :level="2">Stepper</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Multi-step wizard indicator with panels and navigation.</x-std::text>
        </div>

        <x-std::stepper default-value="workspace" stepper-id="media-stepper" class="max-w-3xl">
            <x-std::stepper.list>
                <x-std::stepper.item value="account" :step="1" :completed="true">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                        <x-std::stepper.label>
                            <x-std::stepper.title>Account</x-std::stepper.title>
                            <x-std::stepper.description>Owner details</x-std::stepper.description>
                        </x-std::stepper.label>
                    </x-std::stepper.trigger>
                    <x-std::stepper.separator />
                </x-std::stepper.item>
                <x-std::stepper.item value="workspace" :step="2">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                        <x-std::stepper.label>
                            <x-std::stepper.title>Workspace</x-std::stepper.title>
                            <x-std::stepper.description>Name and region</x-std::stepper.description>
                        </x-std::stepper.label>
                    </x-std::stepper.trigger>
                    <x-std::stepper.separator />
                </x-std::stepper.item>
                <x-std::stepper.item value="review" :step="3">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                        <x-std::stepper.label>
                            <x-std::stepper.title>Review</x-std::stepper.title>
                            <x-std::stepper.description>Confirm setup</x-std::stepper.description>
                        </x-std::stepper.label>
                    </x-std::stepper.trigger>
                </x-std::stepper.item>
            </x-std::stepper.list>

            <div class="w-full space-y-4">
                <x-std::stepper.content value="account">Account step</x-std::stepper.content>
                <x-std::stepper.content value="workspace">
                    Choose a workspace name and the region where project data will live.
                </x-std::stepper.content>
                <x-std::stepper.content value="review">Review step</x-std::stepper.content>

                <x-std::stepper.navigation>
                    <x-std::stepper.previous />
                    <x-std::stepper.next />
                </x-std::stepper.navigation>
            </div>
        </x-std::stepper>
    </div>
@endsection
