Free-text tags input. Submits multiple strings as `name[]`. Enter or comma adds a tag; Backspace on empty input or chip remove button deletes. Included in `@stencilScripts`.

```blade
<x-ui::pillbox name="tags" :value="old('tags', [])" placeholder="Add tags…" :max="10" />

<x-ui::field name="tags">
    <x-ui::field.label>Tags</x-ui::field.label>
    <x-ui::pillbox name="tags" />
    <x-ui::field.errors name="tags" />
</x-ui::field>
```

<br>
