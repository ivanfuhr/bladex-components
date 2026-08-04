Composition-first repeater for dynamic Laravel array fields. Subcomponents include `item`, `add`, and `remove`. Included in `@stencilScripts`.

Declare one `repeater.item` row template with `data-repeater-field` on each control. The script clones rows, reindexes `name="members[0][field]"` attributes, and hydrates from `:value` / `old()`. Use `min` / `max` to control row limits. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-ui::repeater name="members" :value="old('members', [])" :min="1" :max="10">
    <x-ui::repeater.item>
        <x-ui::input data-repeater-field="name" placeholder="Name" />
        <x-ui::input data-repeater-field="role" placeholder="Role" />
        <x-ui::repeater.remove />
    </x-ui::repeater.item>

    <x-ui::repeater.add>Add member</x-ui::repeater.add>
</x-ui::repeater>

<x-ui::field name="members">
    <x-ui::field.label>Team members</x-ui::field.label>
    <x-ui::repeater name="members" :min="1">
        <x-ui::repeater.item>
            <x-ui::input data-repeater-field="name" placeholder="Name" />
            <x-ui::repeater.remove />
        </x-ui::repeater.item>
        <x-ui::repeater.add />
    </x-ui::repeater>
    <x-ui::field.errors name="members" />
</x-ui::field>
```

v1 limits: no nested repeaters or `file-upload` rows inside a repeater item. Use `repeater.duplicate` to clone a row, `repeater.handle` with `sortable` for drag reorder, and `field.errors` with wildcard names like `members.*.name` for per-index validation messages.

Validate the collection and each row field on the server:

```php
$request->validate([
    'members' => ['required', 'array', 'min:1', 'max:10'],
    'members.*.name' => ['required', 'string', 'max:255'],
    'members.*.role' => ['required', 'string', 'max:255'],
]);
```

Put `data-repeater-field` on the control that should submit (usually the `input` itself). After add/remove, the script dispatches `stencil:mount` so sibling Stencil widgets (`select`, `combobox`, date/time pickers, etc.) can initialize inside cloned rows.

<br>
