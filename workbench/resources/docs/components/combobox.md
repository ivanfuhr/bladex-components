Accessible filterable combobox / autocomplete (WAI-ARIA combobox + listbox). Subcomponents include `input`, `content`, `empty`, `group`, `label`, `item`, and `separator`. Included in `@stencilScripts`. Single-select for now; typeahead filters options client-side and shows the empty state when nothing matches.

Default `shortcut` wraps items with `combobox.input`, `combobox.content`, and `combobox.empty`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-ui::combobox name="framework" placeholder="Search frameworks…">
    <x-ui::combobox.group>
        <x-ui::combobox.label>PHP</x-ui::combobox.label>
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        <x-ui::combobox.item value="symfony">Symfony</x-ui::combobox.item>
    </x-ui::combobox.group>
    <x-ui::combobox.separator />
    <x-ui::combobox.item value="react">React</x-ui::combobox.item>
    <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="lang" size="sm" placeholder="Find a language…">
    <x-ui::combobox.item value="php">PHP</x-ui::combobox.item>
    <x-ui::combobox.item value="js">JavaScript</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="bad" placeholder="Invalid" invalid>
    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="off" placeholder="Disabled" disabled>
    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
</x-ui::combobox>

{{-- Full composition --}}
<x-ui::combobox name="framework" :shortcut="false">
    <x-ui::combobox.input placeholder="Search frameworks…" />
    <x-ui::combobox.content>
        <x-ui::combobox.empty>No frameworks found.</x-ui::combobox.empty>
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
    </x-ui::combobox.content>
</x-ui::combobox>

<x-ui::field name="framework">
    <x-ui::field.label>Framework</x-ui::field.label>
    <x-ui::combobox name="framework" placeholder="Search…">
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
    </x-ui::combobox>
    <x-ui::field.errors name="framework" />
</x-ui::field>
```

<br>
