@php
    /** @var array<string, mixed> $state */
@endphp

<div class="flex w-full max-w-lg flex-col gap-4">
    <x-ui::dialog.trigger name="playbook-command">
        <x-ui::button variant="outline" class="w-full justify-between text-zinc-500 dark:text-zinc-400">
            <span class="inline-flex items-center gap-2">
                <x-ui::icon name="search" class="size-4" />
                Search commands…
            </span>
            <span class="rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">⌘K</span>
        </x-ui::button>
    </x-ui::dialog.trigger>

    <x-ui::command.dialog name="playbook-command" shortcut="meta.k">
        <x-ui::command placeholder="Type a command or search…">
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
    </x-ui::command.dialog>

    <x-ui::command
        class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
        placeholder="Filter actions…"
    >
        <x-ui::command.group heading="Actions">
            <x-ui::command.item value="new-file">Create new file</x-ui::command.item>
            <x-ui::command.item value="new-project" kbd="⌘⇧N">Create new project</x-ui::command.item>
            <x-ui::command.item value="docs">Documentation</x-ui::command.item>
        </x-ui::command.group>
    </x-ui::command>
</div>
