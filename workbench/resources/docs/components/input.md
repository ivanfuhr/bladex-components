Affixes, `prefix` / `suffix` (shortcut sugar for `input.group` + `group.prefix` / `group.suffix`), and `invalid`, `disabled`, and `readonly` states.

```blade
<x-std::input name="email" type="email" placeholder="you@example.com">
    <x-slot:leading>
        <x-std::icon.loading />
    </x-slot:leading>
    <x-slot:trailing>
        <x-std::text inline size="sm" variant="subtle">Clear</x-std::text>
    </x-slot:trailing>
</x-std::input>

<x-std::input name="site" placeholder="yoursite" prefix="https://" suffix=".com" />

{{-- Explicit group composition (same markup as prefix / suffix shortcuts) --}}
<x-std::input.group class="max-w-md">
    <x-std::input.group.prefix>https://</x-std::input.group.prefix>
    <x-std::input name="website" in-group placeholder="example.com" />
    <x-std::input.group.suffix>.com</x-std::input.group.suffix>
</x-std::input.group>

<x-std::input name="email" value="not-an-email" invalid />

<x-std::input name="a" placeholder="Disabled" disabled />
<x-std::input name="b" value="Read only" readonly />

<x-std::button variant="outline">Button</x-std::button>
<x-std::input name="align-default" placeholder="Input" class="w-36" />
<x-std::select name="align-select-default" placeholder="Select…" class="w-40">
    <x-std::select.item value="a">Option A</x-std::select.item>
</x-std::select>
<x-std::switch name="align-switch-default" :checked="true" />

<x-std::button variant="outline" size="sm">Button</x-std::button>
<x-std::input name="align-sm" size="sm" placeholder="Input" class="w-36" />
<x-std::select name="align-select-sm" size="sm" placeholder="Select…" class="w-40">
    <x-std::select.item value="a">Option A</x-std::select.item>
</x-std::select>
<x-std::switch name="align-switch-sm" size="sm" :checked="true" />
```

<br>
