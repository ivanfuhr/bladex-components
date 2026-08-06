Accessible filterable combobox / autocomplete (WAI-ARIA combobox + listbox). Subcomponents include `input`, `content`, `empty`, `group`, `label`, `item`, and `separator`. Included in `@stdScripts`. Single-select for now; typeahead filters options client-side and shows the empty state when nothing matches.

Default `shortcut` wraps items with `combobox.input`, `combobox.content`, and `combobox.empty`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-std::combobox name="framework" placeholder="Search frameworks…">
    <x-std::combobox.group>
        <x-std::combobox.label>PHP</x-std::combobox.label>
        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
        <x-std::combobox.item value="symfony">Symfony</x-std::combobox.item>
    </x-std::combobox.group>
    <x-std::combobox.separator />
    <x-std::combobox.item value="react">React</x-std::combobox.item>
    <x-std::combobox.item value="vue">Vue</x-std::combobox.item>
</x-std::combobox>

<x-std::combobox name="lang" size="sm" placeholder="Find a language…">
    <x-std::combobox.item value="php">PHP</x-std::combobox.item>
    <x-std::combobox.item value="js">JavaScript</x-std::combobox.item>
</x-std::combobox>

<x-std::combobox name="bad" placeholder="Invalid" invalid>
    <x-std::combobox.item value="x">Option</x-std::combobox.item>
</x-std::combobox>

<x-std::combobox name="off" placeholder="Disabled" disabled>
    <x-std::combobox.item value="x">Option</x-std::combobox.item>
</x-std::combobox>

{{-- Full composition --}}
<x-std::combobox name="framework" :shortcut="false">
    <x-std::combobox.input placeholder="Search frameworks…" />
    <x-std::combobox.content>
        <x-std::combobox.empty>No frameworks found.</x-std::combobox.empty>
        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
    </x-std::combobox.content>
</x-std::combobox>

<x-std::field name="framework">
    <x-std::field.label>Framework</x-std::field.label>
    <x-std::combobox name="framework" placeholder="Search…">
        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
    </x-std::combobox>
    <x-std::field.errors name="framework" />
</x-std::field>
```

<br>
