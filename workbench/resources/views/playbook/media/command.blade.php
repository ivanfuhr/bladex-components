@extends('workbench::playbook.media.layout')

@section('title', 'Command — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::command /&gt;</p>
            <x-stencil::heading :level="2">Command</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Filterable command palette with ⌘K dialog and inline list.</x-stencil::text>
        </div>

        <div class="mx-auto w-full max-w-lg space-y-6">
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">Inline</x-stencil::text>
                <x-stencil::command
                    class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
                    placeholder="Type a command or search…"
                >
                    <x-stencil::command.group heading="Suggestions">
                        <x-stencil::command.item value="calendar" kbd="⌘C">Calendar</x-stencil::command.item>
                        <x-stencil::command.item value="emoji">Search Emoji</x-stencil::command.item>
                        <x-stencil::command.item value="calculator">Calculator</x-stencil::command.item>
                    </x-stencil::command.group>
                    <x-stencil::command.separator />
                    <x-stencil::command.group heading="Settings">
                        <x-stencil::command.item value="profile" kbd="⌘P">Profile</x-stencil::command.item>
                        <x-stencil::command.item value="billing" kbd="⌘B">Billing</x-stencil::command.item>
                        <x-stencil::command.item value="settings" kbd="⌘S">Settings</x-stencil::command.item>
                    </x-stencil::command.group>
                </x-stencil::command>
            </div>
        </div>
    </div>
@endsection
