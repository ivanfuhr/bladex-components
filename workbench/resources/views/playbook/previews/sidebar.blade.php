@php
    $collapsible = (string) ($state['collapsible'] ?? 'icon');
    $variant = (string) ($state['variant'] ?? 'sidebar');
    $defaultOpen = (bool) ($state['default_open'] ?? true);
@endphp

<div class="h-[28rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-ui::sidebar.provider :default-open="$defaultOpen" storage-key="stencil-playbook-sidebar" class="min-h-full">
        <x-ui::sidebar :collapsible="$collapsible" :variant="$variant">
            <x-ui::sidebar.header>
                <x-ui::sidebar.menu>
                    <x-ui::sidebar.menu-item>
                        <x-ui::sidebar.menu-button href="#" class="font-semibold">
                            <span class="flex size-4 items-center justify-center rounded bg-zinc-900 text-[10px] text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">S</span>
                            <span>Stencil</span>
                        </x-ui::sidebar.menu-button>
                    </x-ui::sidebar.menu-item>
                </x-ui::sidebar.menu>
            </x-ui::sidebar.header>

            <x-ui::sidebar.content>
                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Platform</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" active> Home </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#">Projects</x-ui::sidebar.menu-button>
                                <x-ui::sidebar.menu-badge>12</x-ui::sidebar.menu-badge>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#">Settings</x-ui::sidebar.menu-button>
                                <x-ui::sidebar.menu-sub>
                                    <x-ui::sidebar.menu-sub-item>
                                        <x-ui::sidebar.menu-sub-button href="#"> General</x-ui::sidebar.menu-sub-button>
                                    </x-ui::sidebar.menu-sub-item>
                                    <x-ui::sidebar.menu-sub-item>
                                        <x-ui::sidebar.menu-sub-button href="#" active>
                                            Team</x-ui::sidebar.menu-sub-button>
                                    </x-ui::sidebar.menu-sub-item>
                                </x-ui::sidebar.menu-sub>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>

                <x-ui::sidebar.separator />

                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Support</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#">Documentation</x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>
            </x-ui::sidebar.content>

            <x-ui::sidebar.footer>
                <x-ui::sidebar.menu>
                    <x-ui::sidebar.menu-item>
                        <x-ui::sidebar.menu-button href="#">Account</x-ui::sidebar.menu-button>
                    </x-ui::sidebar.menu-item>
                </x-ui::sidebar.menu>
            </x-ui::sidebar.footer>

            <x-ui::sidebar.rail />
        </x-ui::sidebar>

        <x-ui::sidebar.inset>
            <header class="flex h-12 items-center gap-2 border-b border-zinc-200 px-3 dark:border-zinc-800">
                <x-ui::sidebar.trigger />
                <span class="text-sm font-medium text-zinc-950 dark:text-zinc-50">Dashboard</span>
            </header>
            <div class="p-4">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Main content sits in <code class="font-mono text-xs">sidebar.inset</code>. Toggle with the trigger
                    or
                    <kbd class="rounded border border-zinc-200 px-1 font-mono text-[10px] dark:border-zinc-700">⌘B</kbd
                    >.
                </p>
            </div>
        </x-ui::sidebar.inset>
    </x-ui::sidebar.provider>
</div>
