Accessible vertically stacked disclosures ([shadcn Accordion](https://ui.shadcn.com/docs/components/accordion), [Flux accordion](https://fluxui.dev/components/accordion)). Subcomponents include `item`, `trigger`, and `content`. Included in `@stdScripts`.

```blade
<x-std::accordion exclusive transition>
    <x-std::accordion.item value="shipping" :expanded="true">
        <x-std::accordion.trigger>What are your shipping options?</x-std::accordion.trigger>
        <x-std::accordion.content>
            Standard (5–7 days), express (2–3 days), and overnight.
        </x-std::accordion.content>
    </x-std::accordion.item>

    <x-std::accordion.item heading="What is your return policy?">
        30-day money-back guarantee on unused items.
    </x-std::accordion.item>
</x-std::accordion>
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
