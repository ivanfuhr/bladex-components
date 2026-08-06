Accessible listbox (not a native `<select>`). Subcomponents include `trigger`, `value`, `chips`, `chip`, `content`, `group`, `label`, `item`, and `separator`. Included in `@stdScripts`.

Use `multiple` for multi-select. The field name is normalized to `name[]` when needed. Pass `:value` as an array for pre-selected options. `display="count"` (default) shows a summary such as `3 selected`; `display="chips"` shows removable badges in the trigger (compose with `select.chips` inside `select.trigger` when `shortcut` is false).

```blade
<x-std::select name="industry" placeholder="Choose industry…">
    <x-std::select.group>
        <x-std::select.label>Creative</x-std::select.label>
        <x-std::select.item value="photo">Photography</x-std::select.item>
        <x-std::select.item value="design">Design services</x-std::select.item>
    </x-std::select.group>
    <x-std::select.separator />
    <x-std::select.item value="web">Web development</x-std::select.item>
    <x-std::select.item value="other">Other</x-std::select.item>
</x-std::select>

<x-std::select name="role" size="sm" placeholder="Select a role…">
    <x-std::select.item value="admin">Admin</x-std::select.item>
    <x-std::select.item value="editor">Editor</x-std::select.item>
</x-std::select>
<x-std::select name="bad" placeholder="Invalid" invalid>
    <x-std::select.item value="x">Option</x-std::select.item>
</x-std::select>
<x-std::select name="off" placeholder="Disabled" disabled>
    <x-std::select.item value="x">Option</x-std::select.item>
</x-std::select>

<x-std::select name="industries" :multiple="true" placeholder="Choose industries…">
    <x-std::select.item value="photo">Photography</x-std::select.item>
    <x-std::select.item value="web">Web development</x-std::select.item>
</x-std::select>

<x-std::select name="tags" :multiple="true" display="chips" placeholder="Add tags…">
    <x-std::select.item value="laravel">Laravel</x-std::select.item>
    <x-std::select.item value="tailwind">Tailwind</x-std::select.item>
</x-std::select>
```

<br>
