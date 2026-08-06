Aggregate README media for `<x-std::heading />` (semantic levels `1`–`6`) and `<x-std::text />` (`sm` / `default` / `lg` / `xl` scale, variants, and colors). Playbook keeps separate `heading` and `text` pages; `/playbook/media/typography` captures both.

```blade
<x-std::heading :level="1">Heading level 1</x-std::heading>
<x-std::heading :level="2">Heading level 2</x-std::heading>
<x-std::heading :level="3">Heading level 3</x-std::heading>
<x-std::heading :level="4" variant="subtle">Subtle heading</x-std::heading>

<x-std::text size="xl">Extra large body</x-std::text>
<x-std::text size="lg">Large body copy</x-std::text>
<x-std::text>Default body copy with a shared scale.</x-std::text>
<x-std::text size="sm" variant="subtle">Small subtle meta text</x-std::text>
<x-std::text variant="strong">Strong emphasis</x-std::text>
<x-std::text variant="error">Error message</x-std::text>
<x-std::text inline color="blue">Blue</x-std::text>
<x-std::text inline color="emerald"> · Emerald</x-std::text>
<x-std::text inline color="red"> · Red</x-std::text>
```

<br>
