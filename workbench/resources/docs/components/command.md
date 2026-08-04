Accessible command palette ([shadcn Command](https://ui.shadcn.com/docs/components/command) / [cmdk](https://cmdk.paco.me), [Flux command](https://fluxui.dev/components/command)). Subcomponents include `input`, `list`, `empty`, `group`, `item`, `shortcut`, `separator`, and `dialog`. `stencil:add command` copies `command.js` (and pulls `dialog` via registry dependencies) and patches your Vite entry.

Default `shortcut` wraps items with `command.input`, `command.list`, and `command.empty`. Set `:shortcut="false"` for full composition. Use `command.dialog` for a ⌘K-style modal palette (`shortcut="meta.k"` listens on the document; pair with `dialog.trigger` using the same `name`).

```blade
<x-ui::dialog.trigger name="palette">
    <x-ui::button variant="outline">Search…</x-ui::button>
</x-ui::dialog.trigger>

<x-ui::command.dialog name="palette" shortcut="meta.k">
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

{{-- Inline (no dialog) --}}
<x-ui::command class="rounded-xl border border-zinc-200 dark:border-zinc-800" placeholder="Filter actions…">
    <x-ui::command.item value="new-file">Create new file</x-ui::command.item>
    <x-ui::command.item value="docs" href="/docs">Documentation</x-ui::command.item>
</x-ui::command>

{{-- Full composition --}}
<x-ui::command :shortcut="false">
    <x-ui::command.input placeholder="Search…" />
    <x-ui::command.list>
        <x-ui::command.empty>No results found.</x-ui::command.empty>
        <x-ui::command.item value="settings">Settings</x-ui::command.item>
    </x-ui::command.list>
</x-ui::command>
```

| Prop | Description |
| --- | --- |
| `shortcut` (root) | When `true` (default), auto-wraps the slot with input / list / empty |
| `placeholder` / `empty` | Passed through in shortcut mode |
| `shortcut` (`dialog`) | Document hotkey, e.g. `meta.k` or `cmd.k` (normalized to `meta.k`) |
| `name` (`dialog`) | Named dialog for `dialog.trigger` / `window.Stencil.dialog(name)` |
| `value` / `kbd` / `icon` / `href` (`item`) | Action value, shortcut hint, optional Lucide icon, optional link |

Keyboard: typeahead filter, ↑/↓ highlight, Enter select (dispatches `stencil:command:select` and closes the dialog), Escape clears or closes.

<br>
