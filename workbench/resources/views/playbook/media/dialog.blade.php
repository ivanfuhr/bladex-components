@extends('workbench::playbook.media.layout')

@section('title', 'Dialog — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::dialog /&gt;</p>
            <x-std::heading :level="2">Dialog</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Modal layer with compound sub-components, alert confirmations, and optional flyout.
            </x-std::text>
        </div>

        <div class="space-y-3">
            <x-std::text size="sm" variant="subtle">Form dialog</x-std::text>
            <x-std::dialog.content preview>
                <x-std::dialog.header>
                    <x-std::dialog.title>Update profile</x-std::dialog.title>
                    <x-std::dialog.description> Make changes to your personal details.</x-std::dialog.description>
                </x-std::dialog.header>
                <div class="mt-4">
                    <x-std::input name="media_name" placeholder="Your name" class="w-full" />
                </div>
                <x-std::dialog.footer>
                    <x-std::dialog.cancel>Cancel</x-std::dialog.cancel>
                    <x-std::dialog.action>Save changes</x-std::dialog.action>
                </x-std::dialog.footer>
            </x-std::dialog.content>
        </div>

        <div class="space-y-3">
            <x-std::text size="sm" variant="subtle">Alert dialog · small</x-std::text>
            <x-std::dialog.content preview size="sm" :alert="true">
                <x-std::dialog.header>
                    <x-std::dialog.title>Delete project?</x-std::dialog.title>
                    <x-std::dialog.description>
                        You're about to delete this project. This action cannot be reversed.
                    </x-std::dialog.description>
                </x-std::dialog.header>
                <x-std::dialog.footer>
                    <x-std::dialog.cancel>Cancel</x-std::dialog.cancel>
                    <x-std::dialog.action variant="danger">Delete project</x-std::dialog.action>
                </x-std::dialog.footer>
            </x-std::dialog.content>
        </div>
    </div>
@endsection
