@extends('workbench::playbook.media.layout')

@section('title', 'Card — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::card /&gt;</p>
            <x-ui::heading :level="2">Card</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Content container with header, body, and footer.</x-ui::text>
        </div>

        <div class="max-w-md">
            <x-ui::card>
                <x-ui::card.header>
                    <x-ui::card.title>Account</x-ui::card.title>
                    <x-ui::card.description> Manage your profile and billing preferences.</x-ui::card.description>
                </x-ui::card.header>
                <x-ui::card.content>
                    <x-ui::text size="sm">
                        Update your display name, email, and notification settings. Changes apply across all workspaces.
                    </x-ui::text>
                </x-ui::card.content>
                <x-ui::card.footer class="flex justify-end gap-2">
                    <x-ui::button variant="outline">Cancel</x-ui::button>
                    <x-ui::button variant="primary">Save</x-ui::button>
                </x-ui::card.footer>
            </x-ui::card>
        </div>
    </div>
@endsection
