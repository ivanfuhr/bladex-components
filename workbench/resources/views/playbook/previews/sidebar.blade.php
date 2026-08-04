@php
    $collapsible = (string) ($state['collapsible'] ?? 'icon');
    $variant = (string) ($state['variant'] ?? 'sidebar');
    $defaultOpen = (bool) ($state['default_open'] ?? true);
@endphp

<div class="h-[32rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-ui::sidebar.provider
        :default-open="$defaultOpen"
        storage-key="stencil-playbook-sidebar"
        class="min-h-full h-full"
    >
        <x-ui::sidebar :collapsible="$collapsible" :variant="$variant">
            <x-ui::sidebar.header class="border-b border-zinc-200 p-0 dark:border-zinc-800">
                <div class="flex h-14 items-center gap-2 px-2">
                    <x-ui::sidebar.brand href="#" name="Stencil Inc.">
                        <x-slot:logo>
                            <span class="text-xs font-bold">S</span>
                        </x-slot:logo>
                    </x-ui::sidebar.brand>
                </div>
            </x-ui::sidebar.header>

            <x-ui::sidebar.content>
                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Platform</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" active tooltip="Home">
                                    <x-ui::icon name="file" class="size-4" />
                                    <span>Home</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" tooltip="Inbox">
                                    <x-ui::icon name="search" class="size-4" />
                                    <span>Inbox</span>
                                </x-ui::sidebar.menu-button>
                                <x-ui::sidebar.menu-badge>12</x-ui::sidebar.menu-badge>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" tooltip="Documents">
                                    <x-ui::icon name="clipboard" class="size-4" />
                                    <span>Documents</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" tooltip="Calendar">
                                    <x-ui::icon name="calendar" class="size-4" />
                                    <span>Calendar</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" tooltip="Settings">
                                    <x-ui::icon name="star" class="size-4" />
                                    <span>Settings</span>
                                </x-ui::sidebar.menu-button>
                                <x-ui::sidebar.menu-sub>
                                    <x-ui::sidebar.menu-sub-item>
                                        <x-ui::sidebar.menu-sub-button href="#">
                                            General
                                        </x-ui::sidebar.menu-sub-button>
                                    </x-ui::sidebar.menu-sub-item>
                                    <x-ui::sidebar.menu-sub-item>
                                        <x-ui::sidebar.menu-sub-button href="#">
                                            Team
                                        </x-ui::sidebar.menu-sub-button>
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
                                <x-ui::sidebar.menu-button href="#" tooltip="Documentation">
                                    <x-ui::icon name="clipboard" class="size-4" />
                                    <span>Documentation</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>
            </x-ui::sidebar.content>

            <x-ui::sidebar.footer>
                <x-ui::sidebar.menu>
                    <x-ui::sidebar.menu-item>
                        <x-ui::sidebar.menu-button href="#" tooltip="Olivia Martin">
                            <x-ui::avatar name="Olivia Martin" size="sm" circle />
                            <span>Olivia Martin</span>
                        </x-ui::sidebar.menu-button>
                    </x-ui::sidebar.menu-item>
                </x-ui::sidebar.menu>
            </x-ui::sidebar.footer>

            <x-ui::sidebar.rail />
        </x-ui::sidebar>

        <x-ui::sidebar.inset>
            <x-ui::header>
                <div class="flex w-full items-center gap-2 px-4">
                    <x-ui::sidebar.trigger />
                    <x-ui::separator orientation="vertical" class="me-2 h-4!" />
                    <x-ui::breadcrumb>
                        <x-ui::breadcrumb.list>
                            <x-ui::breadcrumb.item class="hidden md:block">
                                <x-ui::breadcrumb.link href="#">Build your application</x-ui::breadcrumb.link>
                            </x-ui::breadcrumb.item>
                            <x-ui::breadcrumb.separator class="hidden md:block" />
                            <x-ui::breadcrumb.item>
                                <x-ui::breadcrumb.page>Data fetching</x-ui::breadcrumb.page>
                            </x-ui::breadcrumb.item>
                        </x-ui::breadcrumb.list>
                    </x-ui::breadcrumb>
                    <div class="ms-auto hidden items-center gap-2 sm:flex">
                        <x-ui::button variant="outline" size="sm">Search</x-ui::button>
                        <x-ui::button size="sm">New</x-ui::button>
                    </div>
                </div>
            </x-ui::header>

            <x-ui::main>
                <x-ui::text size="sm" variant="subtle">
                    Main content sits in <code class="font-mono text-xs">sidebar.inset</code> with
                    <code class="font-mono text-xs">header</code> and <code class="font-mono text-xs">main</code>.
                    Toggle with the trigger, rail edge, or
                    <kbd class="rounded border border-zinc-200 px-1 font-mono text-[10px] dark:border-zinc-700">⌘B</kbd>.
                </x-ui::text>
            </x-ui::main>
        </x-ui::sidebar.inset>
    </x-ui::sidebar.provider>
</div>
