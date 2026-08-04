Accessible action menu ([shadcn Dropdown Menu](https://ui.shadcn.com/docs/components/dropdown-menu), [Flux dropdown](https://fluxui.dev/components/dropdown)). `stencil:add dropdown-menu` copies `dropdown-menu.js`.

```blade
<x-ui::dropdown-menu align="end">
    <x-ui::dropdown-menu.trigger>
        <x-ui::button variant="outline">Open</x-ui::button>
    </x-ui::dropdown-menu.trigger>
    <x-ui::dropdown-menu.content>
        <x-ui::dropdown-menu.label>Account</x-ui::dropdown-menu.label>
        <x-ui::dropdown-menu.item>Profile</x-ui::dropdown-menu.item>
        <x-ui::dropdown-menu.separator />
        <x-ui::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-ui::dropdown-menu.item>
    </x-ui::dropdown-menu.content>
</x-ui::dropdown-menu>
```

<br>
