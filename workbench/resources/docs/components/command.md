Accessible command palette ([shadcn Command](https://ui.shadcn.com/docs/components/command) / [cmdk](https://cmdk.paco.me), [Flux command](https://fluxui.dev/components/command)). Subcomponents include `input`, `list`, `empty`, `group`, `item`, `shortcut`, `separator`, and `dialog`. Included in `@stdScripts`.

Default `shortcut` wraps items with `command.input`, `command.list`, and `command.empty`. Set `:shortcut="false"` for full composition. Use `command.dialog` for a ⌘K-style modal palette (`shortcut="meta.k"` listens on the document; pair with `dialog.trigger` using the same `name`).

```blade
<x-std::dialog.trigger name="palette">
    <x-std::button variant="outline">Search…</x-std::button>
</x-std::dialog.trigger>

<x-std::command.dialog name="palette" shortcut="meta.k">
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

{{-- Inline (no dialog) --}}
<x-std::command class="rounded-xl border border-zinc-200 dark:border-zinc-800" placeholder="Filter actions…">
    <x-std::command.item value="new-file">Create new file</x-std::command.item>
    <x-std::command.item value="docs" href="/docs">Documentation</x-std::command.item>
</x-std::command>

{{-- Full composition --}}
<x-std::command :shortcut="false">
    <x-std::command.input placeholder="Search…" />
    <x-std::command.list>
        <x-std::command.empty>No results found.</x-std::command.empty>
        <x-std::command.item value="settings">Settings</x-std::command.item>
    </x-std::command.list>
</x-std::command>
```

| Prop | Description |
| --- | --- |
| `shortcut` (root) | When `true` (default), auto-wraps the slot with input / list / empty |
| `placeholder` / `empty` | Passed through in shortcut mode |
| `shortcut` (`dialog`) | Document hotkey, e.g. `meta.k` or `cmd.k` (normalized to `meta.k`) |
| `name` (`dialog`) | Named dialog for `dialog.trigger` / `window.StdComponents.dialog(name)` |
| `value` / `kbd` / `icon` / `href` (`item`) | Action value, shortcut hint, optional Lucide icon, optional link |

Keyboard: typeahead filter, ↑/↓ highlight, Enter select (dispatches `std:command:select` and closes the dialog), Escape clears or closes.

<br>
