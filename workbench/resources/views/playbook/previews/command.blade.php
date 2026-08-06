@php
    /** @var array<string, mixed> $state */
@endphp

<div class="flex w-full max-w-lg flex-col gap-4">
    <x-std::dialog.trigger name="playbook-command">
        <x-std::button variant="outline" class="w-full justify-between text-zinc-500 dark:text-zinc-400">
            <span class="inline-flex items-center gap-2">
                <x-std::icon name="search" class="size-4" />
                Search commands…
            </span>
            <span class="rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">⌘K</span>
        </x-std::button>
    </x-std::dialog.trigger>

    <x-std::command.dialog name="playbook-command" shortcut="meta.k">
        <x-std::command placeholder="Type a command or search…">
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
    </x-std::command.dialog>

    <x-std::command
        class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
        placeholder="Filter actions…"
    >
        <x-std::command.group heading="Actions">
            <x-std::command.item value="new-file">Create new file</x-std::command.item>
            <x-std::command.item value="new-project" kbd="⌘⇧N">Create new project</x-std::command.item>
            <x-std::command.item value="docs">Documentation</x-std::command.item>
        </x-std::command.group>
    </x-std::command>
</div>
