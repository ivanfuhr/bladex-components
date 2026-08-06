Accessible action menu ([shadcn Dropdown Menu](https://ui.shadcn.com/docs/components/dropdown-menu), [Flux dropdown](https://fluxui.dev/components/dropdown)). Included in `@stdScripts`.

```blade
<x-std::dropdown-menu align="end">
    <x-std::dropdown-menu.trigger>
        <x-std::button variant="outline">Open</x-std::button>
    </x-std::dropdown-menu.trigger>
    <x-std::dropdown-menu.content>
        <x-std::dropdown-menu.label>Account</x-std::dropdown-menu.label>
        <x-std::dropdown-menu.item>Profile</x-std::dropdown-menu.item>
        <x-std::dropdown-menu.separator />
        <x-std::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-std::dropdown-menu.item>
    </x-std::dropdown-menu.content>
</x-std::dropdown-menu>
```

<br>
