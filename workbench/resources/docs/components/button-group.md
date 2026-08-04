Attach related action buttons with shared borders ([shadcn Button Group](https://ui.shadcn.com/docs/components/button-group), [Flux button.group](https://fluxui.dev/components/button)). Use `toggle-group` when items represent pressed state instead of actions. Orientation: `horizontal` (default) or `vertical`. Optional `button-group.separator` and `button-group.text`.

```blade
<x-ui::button-group aria-label="Document actions">
    <x-ui::button variant="outline">Archive</x-ui::button>
    <x-ui::button variant="outline">Report</x-ui::button>
    <x-ui::button variant="outline">Snooze</x-ui::button>
</x-ui::button-group>

<x-ui::button-group orientation="vertical" aria-label="Zoom">
    <x-ui::button variant="outline" square>+</x-ui::button>
    <x-ui::button variant="outline" square>−</x-ui::button>
</x-ui::button-group>

<x-ui::button-group aria-label="Clipboard">
    <x-ui::button variant="outline">Copy</x-ui::button>
    <x-ui::button-group.separator />
    <x-ui::button variant="outline">Paste</x-ui::button>
</x-ui::button-group>

<x-ui::button-group>
    <x-ui::button-group.text>https://</x-ui::button-group.text>
    <x-ui::button variant="outline">Open</x-ui::button>
</x-ui::button-group>
```

<br>
