Accessible file upload with a drag-and-drop dropzone, selected-file list, and client-side remove. Uses a native `<input type="file">` so multipart form submit works without Livewire. Subcomponents include `dropzone`, `list`, `item`, and `item.remove`. Included in `@stdScripts`.

Default `shortcut` renders a dropzone (customize via the slot or `heading` / `text` props), a file list, and an item template for the script. Set `:shortcut="false"` for full composition. Use `multiple` for multi-file fields (name is normalized to `name[]` when needed). Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-std::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" />

<x-std::file-upload name="attachments" :multiple="true" accept=".pdf,.doc,.docx">
    <x-std::file-upload.dropzone heading="Upload documents" text="PDF or Word up to 10MB" />
</x-std::file-upload>

<x-std::file-upload name="bad" invalid text="Invalid upload" />
<x-std::file-upload name="off" disabled text="Disabled upload" />

{{-- Full composition --}}
<x-std::file-upload name="docs" :multiple="true" :shortcut="false">
    <x-std::file-upload.dropzone heading="Drop files here" text="Any type" />
    <x-std::file-upload.list />
</x-std::file-upload>

<x-std::field name="avatar">
    <x-std::field.label>Avatar</x-std::field.label>
    <x-std::file-upload name="avatar" accept="image/*" />
    <x-std::field.errors name="avatar" />
</x-std::field>
```

Wrap the control in a form with `enctype="multipart/form-data"` (Laravel forms that include files do this automatically when using `@csrf` with `files` / `enctype`).

<br>
