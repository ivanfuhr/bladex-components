Attach related action buttons with shared borders ([shadcn Button Group](https://ui.shadcn.com/docs/components/button-group), [Flux button.group](https://fluxui.dev/components/button)). Use `toggle-group` when items represent pressed state instead of actions. Orientation: `horizontal` (default) or `vertical`. Optional `button-group.separator` and `button-group.text`.

```blade
<x-std::button-group aria-label="Document actions">
    <x-std::button variant="outline">Archive</x-std::button>
    <x-std::button variant="outline">Report</x-std::button>
    <x-std::button variant="outline">Snooze</x-std::button>
</x-std::button-group>

<x-std::button-group orientation="vertical" aria-label="Zoom">
    <x-std::button variant="outline" square>+</x-std::button>
    <x-std::button variant="outline" square>−</x-std::button>
</x-std::button-group>

<x-std::button-group aria-label="Clipboard">
    <x-std::button variant="outline">Copy</x-std::button>
    <x-std::button-group.separator />
    <x-std::button variant="outline">Paste</x-std::button>
</x-std::button-group>

<x-std::button-group>
    <x-std::button-group.text>https://</x-std::button-group.text>
    <x-std::button variant="outline">Open</x-std::button>
</x-std::button-group>
```

<br>
