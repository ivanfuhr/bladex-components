@extends('workbench::playbook.media.layout')

@section('title', 'Card — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::card /&gt;</p>
            <x-std::heading :level="2">Card</x-std::heading>
            <x-std::text size="sm" variant="subtle">Content container with header, body, and footer.</x-std::text>
        </div>

        <div class="max-w-md">
            <x-std::card>
                <x-std::card.header>
                    <x-std::card.title>Account</x-std::card.title>
                    <x-std::card.description> Manage your profile and billing preferences.</x-std::card.description>
                </x-std::card.header>
                <x-std::card.content>
                    <x-std::text size="sm">
                        Update your display name, email, and notification settings. Changes apply across all workspaces.
                    </x-std::text>
                </x-std::card.content>
                <x-std::card.footer class="flex justify-end gap-2">
                    <x-std::button variant="outline">Cancel</x-std::button>
                    <x-std::button variant="primary">Save</x-std::button>
                </x-std::card.footer>
            </x-std::card>
        </div>
    </div>
@endsection
