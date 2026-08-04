Two-state pressed button with `aria-pressed` ([shadcn Toggle](https://ui.shadcn.com/docs/components/toggle)). Variants: `default`, `outline`. Sizes: `sm`, `default`, `lg`. `stencil:add toggle` copies `toggle.js` and patches your Vite entry.

```blade
<x-ui::toggle aria-label="Toggle italic">Italic</x-ui::toggle>
<x-ui::toggle variant="outline" :pressed="true">Bold</x-ui::toggle>
<x-ui::toggle size="sm" variant="outline">Small</x-ui::toggle>
```

<br>
