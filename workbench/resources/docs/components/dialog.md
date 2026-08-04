Accessible modal layer on the native `<dialog>` element ([shadcn alert dialog](https://ui.shadcn.com/docs/components/base/alert-dialog) composition, [Flux modal](https://fluxui.dev/components/modal) ergonomics). Subcomponents include `trigger`, `content`, `header`, `title`, `description`, `footer`, `close`, `cancel`, and `action`. `stencil:add dialog` copies `dialog.js` and patches your Vite entry alongside any other Stencil scripts (for example `select.js`).

Named triggers can live anywhere on the page; use the same `name` on `dialog.trigger` and `dialog.content`. Control dialogs from JavaScript with `window.Stencil.dialog('name').show()` and `window.Stencil.dialogs.closeAll()`.

```blade
<x-ui::dialog>
    <x-ui::dialog.trigger>
        <x-ui::button variant="outline">Edit profile</x-ui::button>
    </x-ui::dialog.trigger>

    <x-ui::dialog.content>
        <x-ui::dialog.header>
            <x-ui::dialog.title>Update profile</x-ui::dialog.title>
            <x-ui::dialog.description>Make changes to your personal details.</x-ui::dialog.description>
        </x-ui::dialog.header>

        <x-ui::input name="name" placeholder="Your name" class="mt-4" />

        <x-ui::dialog.footer>
            <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
            <x-ui::dialog.action>Save changes</x-ui::dialog.action>
        </x-ui::dialog.footer>
    </x-ui::dialog.content>
</x-ui::dialog>

<x-ui::dialog.trigger name="delete-project">
    <x-ui::button variant="danger">Delete</x-ui::button>
</x-ui::dialog.trigger>

<x-ui::dialog.content name="delete-project" size="sm" :alert="true">
    <x-ui::dialog.header>
        <x-ui::dialog.title>Delete project?</x-ui::dialog.title>
        <x-ui::dialog.description>
            You're about to delete this project. This action cannot be reversed.
        </x-ui::dialog.description>
    </x-ui::dialog.header>
    <x-ui::dialog.footer>
        <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
        <x-ui::dialog.action variant="danger">Delete project</x-ui::dialog.action>
    </x-ui::dialog.footer>
</x-ui::dialog.content>
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
