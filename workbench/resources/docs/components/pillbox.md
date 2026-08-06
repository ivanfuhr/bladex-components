Free-text tags input. Submits multiple strings as `name[]`. Enter or comma adds a tag; Backspace on empty input or chip remove button deletes. Included in `@stdScripts`.

```blade
<x-std::pillbox name="tags" :value="old('tags', [])" placeholder="Add tags…" :max="10" />

<x-std::field name="tags">
    <x-std::field.label>Tags</x-std::field.label>
    <x-std::pillbox name="tags" />
    <x-std::field.errors name="tags" />
</x-std::field>
```

<br>
