@extends('workbench::playbook.media.layout')

@section('title', 'Command — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::command /&gt;</p>
            <x-std::heading :level="2">Command</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Filterable command palette with ⌘K dialog and inline list.</x-std::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">Inline</x-std::text>
                <x-std::command
                    class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
                    placeholder="Type a command or search…"
                >
                    <x-std::command.group heading="Suggestions">
                        <x-std::command.item value="calendar" kbd="⌘C">Calendar</x-std::command.item>
                        <x-std::command.item value="emoji">Search Emoji</x-std::command.item>
                        <x-std::command.item value="calculator">Calculator</x-std::command.item>
                    </x-std::command.group>
                    <x-std::command.separator />
                    <x-std::command.group heading="Settings">
                        <x-std::command.item value="profile" kbd="⌘P">Profile</x-std::command.item>
                        <x-std::command.item value="billing" kbd="⌘B">Billing</x-std::command.item>
                        <x-std::command.item value="settings" kbd="⌘S">Settings</x-std::command.item>
                    </x-std::command.group>
                </x-std::command>
            </div>
        </div>
    </div>
@endsection
