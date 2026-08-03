@extends('workbench::playbook.media.layout')

@section('title', 'Dialog — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::dialog /&gt;</p>
            <x-ui::heading :level="2">Dialog</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Modal layer with compound sub-components, alert confirmations, and optional flyout.
            </x-ui::text>
        </div>

        <div class="space-y-3">
            <x-ui::text size="sm" variant="subtle">Form dialog</x-ui::text>
            <x-ui::dialog.content preview>
                <x-ui::dialog.header>
                    <x-ui::dialog.title>Update profile</x-ui::dialog.title>
                    <x-ui::dialog.description> Make changes to your personal details.</x-ui::dialog.description>
                </x-ui::dialog.header>
                <div class="mt-4">
                    <x-ui::input name="media_name" placeholder="Your name" class="w-full" />
                </div>
                <x-ui::dialog.footer>
                    <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
                    <x-ui::dialog.action>Save changes</x-ui::dialog.action>
                </x-ui::dialog.footer>
            </x-ui::dialog.content>
        </div>

        <div class="space-y-3">
            <x-ui::text size="sm" variant="subtle">Alert dialog · small</x-ui::text>
            <x-ui::dialog.content preview size="sm" :alert="true">
                <x-ui::dialog.header>
                    <x-ui::dialog.title>Delete project?</x-ui::dialog.title>
                    <x-ui::dialog.description>
                        You're about to delete this project. This action cannot be reversed.
                    </x-ui::dialog.description>
                </x-ui::dialog.header>
                <x-ui::dialog.footer>
                    <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
                    <x-ui::dialog.action variant="danger">Delete project</x-ui::dialog.action>
                </x-ui::dialog.footer>
            </x-ui::dialog.content>
        </div>
    </div>
@endsection
