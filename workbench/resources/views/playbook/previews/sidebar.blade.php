@php
    $collapsible = (string) ($state['collapsible'] ?? 'icon');
    $variant = (string) ($state['variant'] ?? 'sidebar');
    $defaultOpen = (bool) ($state['default_open'] ?? true);
@endphp

<div class="h-[28rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-stencil::sidebar.provider :default-open="$defaultOpen" storage-key="stencil-playbook-sidebar" class="min-h-full">
        <x-stencil::sidebar :collapsible="$collapsible" :variant="$variant">
            <x-stencil::sidebar.header>
                <x-stencil::sidebar.menu>
                    <x-stencil::sidebar.menu-item>
                        <x-stencil::sidebar.menu-button href="#" class="font-semibold">
                            <span class="flex size-4 items-center justify-center rounded bg-zinc-900 text-[10px] text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">S</span>
                            <span>Stencil</span>
                        </x-stencil::sidebar.menu-button>
                    </x-stencil::sidebar.menu-item>
                </x-stencil::sidebar.menu>
            </x-stencil::sidebar.header>

            <x-stencil::sidebar.content>
                <x-stencil::sidebar.group>
                    <x-stencil::sidebar.group-label>Platform</x-stencil::sidebar.group-label>
                    <x-stencil::sidebar.group-content>
                        <x-stencil::sidebar.menu>
                            <x-stencil::sidebar.menu-item>
                                <x-stencil::sidebar.menu-button href="#" active> Home </x-stencil::sidebar.menu-button>
                            </x-stencil::sidebar.menu-item>
                            <x-stencil::sidebar.menu-item>
                                <x-stencil::sidebar.menu-button href="#">Projects</x-stencil::sidebar.menu-button>
                                <x-stencil::sidebar.menu-badge>12</x-stencil::sidebar.menu-badge>
                            </x-stencil::sidebar.menu-item>
                            <x-stencil::sidebar.menu-item>
                                <x-stencil::sidebar.menu-button href="#">Settings</x-stencil::sidebar.menu-button>
                                <x-stencil::sidebar.menu-sub>
                                    <x-stencil::sidebar.menu-sub-item>
                                        <x-stencil::sidebar.menu-sub-button href="#">
                                            General</x-stencil::sidebar.menu-sub-button>
                                    </x-stencil::sidebar.menu-sub-item>
                                    <x-stencil::sidebar.menu-sub-item>
                                        <x-stencil::sidebar.menu-sub-button href="#" active>
                                            Team</x-stencil::sidebar.menu-sub-button>
                                    </x-stencil::sidebar.menu-sub-item>
                                </x-stencil::sidebar.menu-sub>
                            </x-stencil::sidebar.menu-item>
                        </x-stencil::sidebar.menu>
                    </x-stencil::sidebar.group-content>
                </x-stencil::sidebar.group>

                <x-stencil::sidebar.separator />

                <x-stencil::sidebar.group>
                    <x-stencil::sidebar.group-label>Support</x-stencil::sidebar.group-label>
                    <x-stencil::sidebar.group-content>
                        <x-stencil::sidebar.menu>
                            <x-stencil::sidebar.menu-item>
                                <x-stencil::sidebar.menu-button href="#">Documentation</x-stencil::sidebar.menu-button>
                            </x-stencil::sidebar.menu-item>
                        </x-stencil::sidebar.menu>
                    </x-stencil::sidebar.group-content>
                </x-stencil::sidebar.group>
            </x-stencil::sidebar.content>

            <x-stencil::sidebar.footer>
                <x-stencil::sidebar.menu>
                    <x-stencil::sidebar.menu-item>
                        <x-stencil::sidebar.menu-button href="#">Account</x-stencil::sidebar.menu-button>
                    </x-stencil::sidebar.menu-item>
                </x-stencil::sidebar.menu>
            </x-stencil::sidebar.footer>

            <x-stencil::sidebar.rail />
        </x-stencil::sidebar>

        <x-stencil::sidebar.inset>
            <header class="flex h-12 items-center gap-2 border-b border-zinc-200 px-3 dark:border-zinc-800">
                <x-stencil::sidebar.trigger />
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
        </x-stencil::sidebar.inset>
    </x-stencil::sidebar.provider>
</div>
