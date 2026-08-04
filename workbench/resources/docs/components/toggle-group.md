Single or multiple selection among toggle items ([shadcn Toggle Group](https://ui.shadcn.com/docs/components/toggle-group), Flux segmented / buttons radio & checkbox groups). `type="single"` uses `role="radiogroup"`; `type="multiple"` uses `role="group"` with `aria-pressed`. Pass `default-value` for the initial selection (string, or array for `multiple`). `spacing="0"` (default) connects items; use `spacing="2"` for a gap. Included in `@stencilScripts`.

```blade
<x-ui::toggle-group type="single" variant="outline" default-value="bold" aria-label="Text style">
    <x-ui::toggle-group.item value="bold">Bold</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="italic">Italic</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="underline">Underline</x-ui::toggle-group.item>
</x-ui::toggle-group>

<x-ui::toggle-group type="multiple" variant="outline" :default-value="['bold']" aria-label="Format">
    <x-ui::toggle-group.item value="bold">Bold</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="italic">Italic</x-ui::toggle-group.item>
</x-ui::toggle-group>

<x-ui::toggle-group orientation="vertical" variant="outline" spacing="2">
    <x-ui::toggle-group.item value="left">Left</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="center">Center</x-ui::toggle-group.item>
</x-ui::toggle-group>
```

<br>
