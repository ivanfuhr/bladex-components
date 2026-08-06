Accessible modal layer on the native `<dialog>` element ([shadcn alert dialog](https://ui.shadcn.com/docs/components/base/alert-dialog) composition, [Flux modal](https://fluxui.dev/components/modal) ergonomics). Subcomponents include `trigger`, `content`, `header`, `title`, `description`, `footer`, `close`, `cancel`, and `action`. Included in `@stdScripts`.

Named triggers can live anywhere on the page; use the same `name` on `dialog.trigger` and `dialog.content`. Control dialogs from JavaScript with `window.StdComponents.dialog('name').show()` and `window.StdComponents.dialogs.closeAll()`.

```blade
<x-std::dialog>
    <x-std::dialog.trigger>
        <x-std::button variant="outline">Edit profile</x-std::button>
    </x-std::dialog.trigger>

    <x-std::dialog.content>
        <x-std::dialog.header>
            <x-std::dialog.title>Update profile</x-std::dialog.title>
            <x-std::dialog.description>Make changes to your personal details.</x-std::dialog.description>
        </x-std::dialog.header>

        <x-std::input name="name" placeholder="Your name" class="mt-4" />

        <x-std::dialog.footer>
            <x-std::dialog.cancel>Cancel</x-std::dialog.cancel>
            <x-std::dialog.action>Save changes</x-std::dialog.action>
        </x-std::dialog.footer>
    </x-std::dialog.content>
</x-std::dialog>

<x-std::dialog.trigger name="delete-project">
    <x-std::button variant="danger">Delete</x-std::button>
</x-std::dialog.trigger>

<x-std::dialog.content name="delete-project" size="sm" :alert="true">
    <x-std::dialog.header>
        <x-std::dialog.title>Delete project?</x-std::dialog.title>
        <x-std::dialog.description>
            You're about to delete this project. This action cannot be reversed.
        </x-std::dialog.description>
    </x-std::dialog.header>
    <x-std::dialog.footer>
        <x-std::dialog.cancel>Cancel</x-std::dialog.cancel>
        <x-std::dialog.action variant="danger">Delete project</x-std::dialog.action>
    </x-std::dialog.footer>
</x-std::dialog.content>
```

| Prop (on `content`) | Description |
| --- | --- |
| `size` | `default` or `sm` |
| `flyout` | Sheet-style panel (`flyoutPosition`: `right`, `left`, `bottom`) |
| `alert` | Sets `role="alertdialog"` for confirmations |
| `dismissible` | Click outside / Escape closes when `true` (default) |
| `closable` | Shows the corner close control (default) |
| `preview` | Static, in-page preview for docs (no JS) |

<br>
