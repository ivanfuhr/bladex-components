Accessible file upload with a drag-and-drop dropzone, selected-file list, and client-side remove. Uses a native `<input type="file">` so multipart form submit works without Livewire. Subcomponents include `dropzone`, `list`, `item`, and `item.remove`. Included in `@stencilScripts`.

Default `shortcut` renders a dropzone (customize via the slot or `heading` / `text` props), a file list, and an item template for the script. Set `:shortcut="false"` for full composition. Use `multiple` for multi-file fields (name is normalized to `name[]` when needed). Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-ui::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" />

<x-ui::file-upload name="attachments" :multiple="true" accept=".pdf,.doc,.docx">
    <x-ui::file-upload.dropzone heading="Upload documents" text="PDF or Word up to 10MB" />
</x-ui::file-upload>

<x-ui::file-upload name="bad" invalid text="Invalid upload" />
<x-ui::file-upload name="off" disabled text="Disabled upload" />

{{-- Full composition --}}
<x-ui::file-upload name="docs" :multiple="true" :shortcut="false">
    <x-ui::file-upload.dropzone heading="Drop files here" text="Any type" />
    <x-ui::file-upload.list />
</x-ui::file-upload>

<x-ui::field name="avatar">
    <x-ui::field.label>Avatar</x-ui::field.label>
    <x-ui::file-upload name="avatar" accept="image/*" />
    <x-ui::field.errors name="avatar" />
</x-ui::field>
```

Wrap the control in a form with `enctype="multipart/form-data"` (Laravel forms that include files do this automatically when using `@csrf` with `files` / `enctype`).

<br>
