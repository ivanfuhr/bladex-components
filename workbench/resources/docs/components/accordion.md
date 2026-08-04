Accessible vertically stacked disclosures ([shadcn Accordion](https://ui.shadcn.com/docs/components/accordion), [Flux accordion](https://fluxui.dev/components/accordion)). Subcomponents include `item`, `trigger`, and `content`. `stencil:add accordion` copies `accordion.js` and patches your Vite entry.

```blade
<x-ui::accordion exclusive transition>
    <x-ui::accordion.item value="shipping" :expanded="true">
        <x-ui::accordion.trigger>What are your shipping options?</x-ui::accordion.trigger>
        <x-ui::accordion.content>
            Standard (5–7 days), express (2–3 days), and overnight.
        </x-ui::accordion.content>
    </x-ui::accordion.item>

    <x-ui::accordion.item heading="What is your return policy?">
        30-day money-back guarantee on unused items.
    </x-ui::accordion.item>
</x-ui::accordion>
```

| Prop | Description |
| --- | --- |
| `exclusive` / `multiple` | Single open item (`exclusive`) or many (`multiple`) |
| `transition` | Animate open/close height |
| `variant="reverse"` | Chevron before the label (Flux) |
| `bordered` | Rounded bordered shell |
| `item` → `heading` | Shorthand trigger text (Flux) |
| `item` → `expanded` / `disabled` | Default open / non-interactive |

<br>
