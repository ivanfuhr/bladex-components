@extends('workbench::playbook.media.layout')

@section('title', 'Stepper — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::stepper /&gt;</p>
            <x-ui::heading :level="2">Stepper</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Multi-step wizard indicator with panels and navigation.</x-ui::text>
        </div>

        <x-ui::stepper default-value="workspace" stepper-id="media-stepper" class="max-w-3xl">
            <x-ui::stepper.list>
                <x-ui::stepper.item value="account" :step="1" :completed="true">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                        <span class="space-y-0.5 text-left">
                            <x-ui::stepper.title>Account</x-ui::stepper.title>
                            <x-ui::stepper.description>Owner details</x-ui::stepper.description>
                        </span>
                    </x-ui::stepper.trigger>
                    <x-ui::stepper.separator />
                </x-ui::stepper.item>
                <x-ui::stepper.item value="workspace" :step="2">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                        <span class="space-y-0.5 text-left">
                            <x-ui::stepper.title>Workspace</x-ui::stepper.title>
                            <x-ui::stepper.description>Name and region</x-ui::stepper.description>
                        </span>
                    </x-ui::stepper.trigger>
                    <x-ui::stepper.separator />
                </x-ui::stepper.item>
                <x-ui::stepper.item value="review" :step="3">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                        <span class="space-y-0.5 text-left">
                            <x-ui::stepper.title>Review</x-ui::stepper.title>
                            <x-ui::stepper.description>Confirm setup</x-ui::stepper.description>
                        </span>
                    </x-ui::stepper.trigger>
                </x-ui::stepper.item>
            </x-ui::stepper.list>

            <div class="w-full space-y-4">
                <x-ui::stepper.content value="account">Account step</x-ui::stepper.content>
                <x-ui::stepper.content value="workspace">
                    Choose a workspace name and the region where project data will live.
                </x-ui::stepper.content>
                <x-ui::stepper.content value="review">Review step</x-ui::stepper.content>

                <x-ui::stepper.navigation>
                    <x-ui::stepper.previous />
                    <x-ui::stepper.next />
                </x-ui::stepper.navigation>
            </div>
        </x-ui::stepper>
    </div>
@endsection
