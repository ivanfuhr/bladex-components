Tabbed panels ([shadcn Tabs](https://ui.shadcn.com/docs/components/tabs), [Flux tabs](https://fluxui.dev/components/tabs)). Variants: `default`, `segmented`, `pills`, `line`. Included in `@stdScripts`.

```blade
<x-std::tabs default-value="account">
    <x-std::tabs.list>
        <x-std::tabs.trigger value="account">Account</x-std::tabs.trigger>
        <x-std::tabs.trigger value="password">Password</x-std::tabs.trigger>
    </x-std::tabs.list>
    <x-std::tabs.content value="account">Account settings</x-std::tabs.content>
    <x-std::tabs.content value="password">Password settings</x-std::tabs.content>
</x-std::tabs>
```

<br>
