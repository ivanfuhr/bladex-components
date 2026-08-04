Composable app-shell navigation ([shadcn Sidebar](https://ui.shadcn.com/docs/components/sidebar), [Flux sidebar](https://fluxui.dev/components/sidebar)). Subcomponents include `provider`, `trigger`, `inset`, `header`, `footer`, `content`, `group`, `group-label`, `group-content`, `group-action`, `menu`, `menu-item`, `menu-button`, `menu-action`, `menu-badge`, `menu-sub`, `menu-sub-item`, `menu-sub-button`, `brand`, `separator`, `rail`, and `backdrop`. The `sidebar.brand` subcomponent accepts the same `logo`, `logo-dark`, `alt`, and `logo` slot API as `x-ui::brand`. Collapse modes: `offcanvas`, `icon`, `none`. Open state persists in `localStorage` (not cookies). `stencil:add sidebar` copies `sidebar.js` and the `panel-left` icon.

```blade
<x-ui::sidebar.provider>
    <x-ui::sidebar collapsible="icon">
        <x-ui::sidebar.header>
            <x-ui::sidebar.brand href="/" name="Acme Inc.">
                <x-slot:logo>
                    <span class="text-xs font-bold">A</span>
                </x-slot:logo>
            </x-ui::sidebar.brand>
            <x-ui::sidebar.menu>
                <x-ui::sidebar.menu-item>
                    <x-ui::sidebar.menu-button href="/" class="font-semibold">Acme</x-ui::sidebar.menu-button>
                </x-ui::sidebar.menu-item>
            </x-ui::sidebar.menu>
        </x-ui::sidebar.header>
        <x-ui::sidebar.content>
            <x-ui::sidebar.group>
                <x-ui::sidebar.group-label>Platform</x-ui::sidebar.group-label>
                <x-ui::sidebar.group-content>
                    <x-ui::sidebar.menu>
                        <x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-button href="/" active>Home</x-ui::sidebar.menu-button>
                        </x-ui::sidebar.menu-item>
                        <x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-button href="/settings">Settings</x-ui::sidebar.menu-button>
                        </x-ui::sidebar.menu-item>
                    </x-ui::sidebar.menu>
                </x-ui::sidebar.group-content>
            </x-ui::sidebar.group>
        </x-ui::sidebar.content>
        <x-ui::sidebar.footer>...</x-ui::sidebar.footer>
        <x-ui::sidebar.rail />
    </x-ui::sidebar>
    <x-ui::sidebar.inset>
        <header class="flex h-12 items-center gap-2 px-3">
            <x-ui::sidebar.trigger />
            <span class="text-sm font-medium">Dashboard</span>
        </header>
        {{ $slot }}
    </x-ui::sidebar.inset>
</x-ui::sidebar.provider>
```

<br>
