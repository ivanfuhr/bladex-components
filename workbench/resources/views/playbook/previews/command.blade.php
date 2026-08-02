@php
    /** @var array<string, mixed> $state */
@endphp

<div class="flex w-full max-w-lg flex-col gap-4">
    <x-stencil::dialog.trigger name="playbook-command">
        <x-stencil::button variant="outline" class="w-full justify-between text-zinc-500 dark:text-zinc-400">
            <span class="inline-flex items-center gap-2">
                <x-stencil::icon name="search" class="size-4" />
                Search commands…
            </span>
            <span class="rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">⌘K</span>
        </x-stencil::button>
    </x-stencil::dialog.trigger>

    <x-stencil::command.dialog name="playbook-command" shortcut="meta.k">
        <x-stencil::command placeholder="Type a command or search…">
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
    </x-stencil::command.dialog>

    <x-stencil::command
        class="rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
        placeholder="Filter actions…"
    >
        <x-stencil::command.group heading="Actions">
            <x-stencil::command.item value="new-file">Create new file</x-stencil::command.item>
            <x-stencil::command.item value="new-project" kbd="⌘⇧N">Create new project</x-stencil::command.item>
            <x-stencil::command.item value="docs">Documentation</x-stencil::command.item>
        </x-stencil::command.group>
    </x-stencil::command>
</div>
