@extends('workbench::playbook.media.layout')

@section('title', 'Command — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::command /&gt;</p>
            <x-ui::heading :level="2">Command</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Filterable command palette with ⌘K dialog and inline list.</x-ui::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">Inline</x-ui::text>
                <x-ui::command
                    class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
                    placeholder="Type a command or search…"
                >
                    <x-ui::command.group heading="Suggestions">
                        <x-ui::command.item value="calendar" kbd="⌘C">Calendar</x-ui::command.item>
                        <x-ui::command.item value="emoji">Search Emoji</x-ui::command.item>
                        <x-ui::command.item value="calculator">Calculator</x-ui::command.item>
                    </x-ui::command.group>
                    <x-ui::command.separator />
                    <x-ui::command.group heading="Settings">
                        <x-ui::command.item value="profile" kbd="⌘P">Profile</x-ui::command.item>
                        <x-ui::command.item value="billing" kbd="⌘B">Billing</x-ui::command.item>
                        <x-ui::command.item value="settings" kbd="⌘S">Settings</x-ui::command.item>
                    </x-ui::command.group>
                </x-ui::command>
            </div>
        </div>
    </div>
@endsection
