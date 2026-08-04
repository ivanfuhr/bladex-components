Accessible listbox (not a native `<select>`). Subcomponents include `trigger`, `value`, `chips`, `chip`, `content`, `group`, `label`, `item`, and `separator`. Included in `@stencilScripts`.

Use `multiple` for multi-select. The field name is normalized to `name[]` when needed. Pass `:value` as an array for pre-selected options. `display="count"` (default) shows a summary such as `3 selected`; `display="chips"` shows removable badges in the trigger (compose with `select.chips` inside `select.trigger` when `shortcut` is false).

```blade
<x-ui::select name="industry" placeholder="Choose industry…">
    <x-ui::select.group>
        <x-ui::select.label>Creative</x-ui::select.label>
        <x-ui::select.item value="photo">Photography</x-ui::select.item>
        <x-ui::select.item value="design">Design services</x-ui::select.item>
    </x-ui::select.group>
    <x-ui::select.separator />
    <x-ui::select.item value="web">Web development</x-ui::select.item>
    <x-ui::select.item value="other">Other</x-ui::select.item>
</x-ui::select>

<x-ui::select name="role" size="sm" placeholder="Select a role…">
    <x-ui::select.item value="admin">Admin</x-ui::select.item>
    <x-ui::select.item value="editor">Editor</x-ui::select.item>
</x-ui::select>
<x-ui::select name="bad" placeholder="Invalid" invalid>
    <x-ui::select.item value="x">Option</x-ui::select.item>
</x-ui::select>
<x-ui::select name="off" placeholder="Disabled" disabled>
    <x-ui::select.item value="x">Option</x-ui::select.item>
</x-ui::select>

<x-ui::select name="industries" :multiple="true" placeholder="Choose industries…">
    <x-ui::select.item value="photo">Photography</x-ui::select.item>
    <x-ui::select.item value="web">Web development</x-ui::select.item>
</x-ui::select>

<x-ui::select name="tags" :multiple="true" display="chips" placeholder="Add tags…">
    <x-ui::select.item value="laravel">Laravel</x-ui::select.item>
    <x-ui::select.item value="tailwind">Tailwind</x-ui::select.item>
</x-ui::select>
```

<br>
