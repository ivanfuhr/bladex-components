Tabbed panels ([shadcn Tabs](https://ui.shadcn.com/docs/components/tabs), [Flux tabs](https://fluxui.dev/components/tabs)). Variants: `default`, `segmented`, `pills`, `line`. `stencil:add tabs` copies `tabs.js`.

```blade
<x-ui::tabs default-value="account">
    <x-ui::tabs.list>
        <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
        <x-ui::tabs.trigger value="password">Password</x-ui::tabs.trigger>
    </x-ui::tabs.list>
    <x-ui::tabs.content value="account">Account settings</x-ui::tabs.content>
    <x-ui::tabs.content value="password">Password settings</x-ui::tabs.content>
</x-ui::tabs>
```

<br>
