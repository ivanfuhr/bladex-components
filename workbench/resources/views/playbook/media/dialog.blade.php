@extends('workbench::playbook.media.layout')

@section('title', 'Dialog — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::dialog /&gt;</p>
            <x-stencil::heading :level="2">Dialog</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Modal layer with compound sub-components, alert confirmations, and optional flyout.
            </x-stencil::text>
        </div>

        <div class="space-y-3">
            <x-stencil::text size="sm" variant="subtle">Form dialog</x-stencil::text>
            <x-stencil::dialog.content preview class="w-full min-w-[min(100%,42rem)]">
                <x-stencil::dialog.header>
                    <x-stencil::dialog.title>Update profile</x-stencil::dialog.title>
                    <x-stencil::dialog.description>Make changes to your personal details.</x-stencil::dialog.description>
                </x-stencil::dialog.header>
                <div class="mt-4">
                    <x-stencil::input name="media_name" placeholder="Your name" class="w-full" />
                </div>
                <x-stencil::dialog.footer>
                    <x-stencil::dialog.cancel>Cancel</x-stencil::dialog.cancel>
                    <x-stencil::dialog.action>Save changes</x-stencil::dialog.action>
                </x-stencil::dialog.footer>
            </x-stencil::dialog.content>
        </div>

        <div class="space-y-3">
            <x-stencil::text size="sm" variant="subtle">Alert dialog · small</x-stencil::text>
            <x-stencil::dialog.content preview size="sm" :alert="true" class="w-full min-w-[min(100%,42rem)]">
                <x-stencil::dialog.header>
                    <x-stencil::dialog.title>Delete project?</x-stencil::dialog.title>
                    <x-stencil::dialog.description>
                        You're about to delete this project. This action cannot be reversed.
                    </x-stencil::dialog.description>
                </x-stencil::dialog.header>
                <x-stencil::dialog.footer>
                    <x-stencil::dialog.cancel>Cancel</x-stencil::dialog.cancel>
                    <x-stencil::dialog.action variant="danger">Delete project</x-stencil::dialog.action>
                </x-stencil::dialog.footer>
            </x-stencil::dialog.content>
        </div>
    </div>
@endsection
