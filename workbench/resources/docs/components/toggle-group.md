Single or multiple selection among toggle items ([shadcn Toggle Group](https://ui.shadcn.com/docs/components/toggle-group), Flux segmented / buttons radio & checkbox groups). `type="single"` uses `role="radiogroup"`; `type="multiple"` uses `role="group"` with `aria-pressed`. Pass `default-value` for the initial selection (string, or array for `multiple`). `spacing="0"` (default) connects items; use `spacing="2"` for a gap. Included in `@stdScripts`.

```blade
<x-std::toggle-group type="single" variant="outline" default-value="bold" aria-label="Text style">
    <x-std::toggle-group.item value="bold">Bold</x-std::toggle-group.item>
    <x-std::toggle-group.item value="italic">Italic</x-std::toggle-group.item>
    <x-std::toggle-group.item value="underline">Underline</x-std::toggle-group.item>
</x-std::toggle-group>

<x-std::toggle-group type="multiple" variant="outline" :default-value="['bold']" aria-label="Format">
    <x-std::toggle-group.item value="bold">Bold</x-std::toggle-group.item>
    <x-std::toggle-group.item value="italic">Italic</x-std::toggle-group.item>
</x-std::toggle-group>

<x-std::toggle-group orientation="vertical" variant="outline" spacing="2">
    <x-std::toggle-group.item value="left">Left</x-std::toggle-group.item>
    <x-std::toggle-group.item value="center">Center</x-std::toggle-group.item>
</x-std::toggle-group>
```

<br>
