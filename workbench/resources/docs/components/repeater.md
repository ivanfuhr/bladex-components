Composition-first repeater for dynamic Laravel array fields. Subcomponents include `item`, `add`, and `remove`. Included in `@stdScripts`.

Declare one `repeater.item` row template with `data-repeater-field` on each control. The script clones rows, reindexes `name="members[0][field]"` attributes, and hydrates from `:value` / `old()`. Use `min` / `max` to control row limits. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-std::repeater name="members" :value="old('members', [])" :min="1" :max="10">
    <x-std::repeater.item>
        <x-std::input data-repeater-field="name" placeholder="Name" />
        <x-std::input data-repeater-field="role" placeholder="Role" />
        <x-std::repeater.remove />
    </x-std::repeater.item>

    <x-std::repeater.add>Add member</x-std::repeater.add>
</x-std::repeater>

<x-std::field name="members">
    <x-std::field.label>Team members</x-std::field.label>
    <x-std::repeater name="members" :min="1">
        <x-std::repeater.item>
            <x-std::input data-repeater-field="name" placeholder="Name" />
            <x-std::repeater.remove />
        </x-std::repeater.item>
        <x-std::repeater.add />
    </x-std::repeater>
    <x-std::field.errors name="members" />
</x-std::field>
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

Put `data-repeater-field` on the control that should submit (usually the `input` itself). After add/remove, the script dispatches `std:mount` so sibling Std Components widgets (`select`, `combobox`, date/time pickers, etc.) can initialize inside cloned rows.

<br>
