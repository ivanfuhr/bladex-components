@extends('workbench::playbook.media.layout')

@section('title', 'Card — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::card /&gt;</p>
            <x-stencil::heading :level="2">Card</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Content container with header, body, and footer.</x-stencil::text>
        </div>

        <div class="max-w-md">
            <x-stencil::card>
                <x-stencil::card.header>
                    <x-stencil::card.title>Account</x-stencil::card.title>
                    <x-stencil::card.description>
                        Manage your profile and billing preferences.</x-stencil::card.description>
                </x-stencil::card.header>
                <x-stencil::card.content>
                    <x-stencil::text size="sm">
                        Update your display name, email, and notification settings. Changes apply across all workspaces.
                    </x-stencil::text>
                </x-stencil::card.content>
                <x-stencil::card.footer class="flex justify-end gap-2">
                    <x-stencil::button variant="outline">Cancel</x-stencil::button>
                    <x-stencil::button variant="primary">Save</x-stencil::button>
                </x-stencil::card.footer>
            </x-stencil::card>
        </div>
    </div>
@endsection
