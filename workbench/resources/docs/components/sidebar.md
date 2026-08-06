Composable app-shell navigation ([shadcn Sidebar](https://ui.shadcn.com/docs/components/sidebar), [Flux sidebar](https://fluxui.dev/components/sidebar)). Subcomponents include `provider`, `trigger`, `inset`, `header`, `footer`, `content`, `group`, `group-label`, `group-content`, `group-action`, `menu`, `menu-item`, `menu-button`, `menu-action`, `menu-badge`, `menu-sub`, `menu-sub-item`, `menu-sub-button`, `brand`, `separator`, `rail`, and `backdrop`. The `sidebar.brand` subcomponent accepts the same `logo`, `logo-dark`, `alt`, and `logo` slot API as `x-std::brand`. Collapse modes: `offcanvas`, `icon`, `none`. Open state persists in `localStorage` (not cookies). Included in `@stdScripts`.

```blade
<x-std::sidebar.provider>
    <x-std::sidebar collapsible="icon">
        <x-std::sidebar.header>
            <x-std::sidebar.brand href="/" name="Acme Inc.">
                <x-slot:logo>
                    <span class="text-xs font-bold">A</span>
                </x-slot:logo>
            </x-std::sidebar.brand>
            <x-std::sidebar.menu>
                <x-std::sidebar.menu-item>
                    <x-std::sidebar.menu-button href="/" class="font-semibold">Acme</x-std::sidebar.menu-button>
                </x-std::sidebar.menu-item>
            </x-std::sidebar.menu>
        </x-std::sidebar.header>
        <x-std::sidebar.content>
            <x-std::sidebar.group>
                <x-std::sidebar.group-label>Platform</x-std::sidebar.group-label>
                <x-std::sidebar.group-content>
                    <x-std::sidebar.menu>
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button href="/" active>Home</x-std::sidebar.menu-button>
                        </x-std::sidebar.menu-item>
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button href="/settings">Settings</x-std::sidebar.menu-button>
                        </x-std::sidebar.menu-item>
                    </x-std::sidebar.menu>
                </x-std::sidebar.group-content>
            </x-std::sidebar.group>
        </x-std::sidebar.content>
        <x-std::sidebar.footer>...</x-std::sidebar.footer>
        <x-std::sidebar.rail />
    </x-std::sidebar>
    <x-std::sidebar.inset>
        <header class="flex h-12 items-center gap-2 px-3">
            <x-std::sidebar.trigger />
            <span class="text-sm font-medium">Dashboard</span>
        </header>
        {{ $slot }}
    </x-std::sidebar.inset>
</x-std::sidebar.provider>
```

<br>
