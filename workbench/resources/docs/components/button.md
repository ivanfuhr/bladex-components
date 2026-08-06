Variants: `outline`, `primary`, `secondary`, `danger`, `ghost`, `subtle`, `link` — sizes `xs`–`lg`, icon mode (`square`), and `leading` / `trailing` slots.

```blade
<x-std::button variant="outline">Outline</x-std::button>
<x-std::button variant="primary">Primary</x-std::button>
<x-std::button variant="secondary">Secondary</x-std::button>
<x-std::button variant="danger">Danger</x-std::button>
<x-std::button variant="ghost">Ghost</x-std::button>
<x-std::button variant="subtle">Subtle</x-std::button>
<x-std::button variant="link">Link</x-std::button>

<x-std::button variant="primary" size="xs">Extra small</x-std::button>
<x-std::button variant="primary" size="sm">Small</x-std::button>
<x-std::button variant="primary">Default</x-std::button>
<x-std::button variant="primary" size="lg">Large</x-std::button>
<x-std::button variant="outline" square>
    <x-std::icon.loading />
</x-std::button>
```

The square button uses the built-in loading icon from. Included in `@stdScripts`.

<br>
