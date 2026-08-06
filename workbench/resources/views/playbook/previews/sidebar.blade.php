@php
    $collapsible = (string) ($state['collapsible'] ?? 'icon');
    $variant = (string) ($state['variant'] ?? 'sidebar');
    $defaultOpen = (bool) ($state['default_open'] ?? true);
@endphp

<div class="h-[32rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
    <x-std::sidebar.provider :default-open="$defaultOpen" storage-key="std-playbook-sidebar" class="h-full min-h-full">
        <x-std::sidebar :collapsible="$collapsible" :variant="$variant">
            <x-std::sidebar.header class="border-b border-zinc-200 p-0 dark:border-zinc-800">
                <div class="flex h-14 items-center gap-2 px-2">
                    <x-std::sidebar.brand href="#" name="Std Components Inc.">
                        <x-slot:logo>
                            <span class="text-xs font-bold">S</span>
                        </x-slot:logo>
                    </x-std::sidebar.brand>
                </div>
            </x-std::sidebar.header>

            <x-std::sidebar.content>
                <x-std::sidebar.group>
                    <x-std::sidebar.group-label>Platform</x-std::sidebar.group-label>
                    <x-std::sidebar.group-content>
                        <x-std::sidebar.menu>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" active tooltip="Home">
                                    <x-std::icon name="file" class="size-4" />
                                    <span>Home</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Inbox">
                                    <x-std::icon name="search" class="size-4" />
                                    <span>Inbox</span>
                                </x-std::sidebar.menu-button>
                                <x-std::sidebar.menu-badge>12</x-std::sidebar.menu-badge>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Documents">
                                    <x-std::icon name="clipboard" class="size-4" />
                                    <span>Documents</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Calendar">
                                    <x-std::icon name="calendar" class="size-4" />
                                    <span>Calendar</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Settings">
                                    <x-std::icon name="star" class="size-4" />
                                    <span>Settings</span>
                                </x-std::sidebar.menu-button>
                                <x-std::sidebar.menu-sub>
                                    <x-std::sidebar.menu-sub-item>
                                        <x-std::sidebar.menu-sub-button href="#">
                                            General
                                        </x-std::sidebar.menu-sub-button>
                                    </x-std::sidebar.menu-sub-item>
                                    <x-std::sidebar.menu-sub-item>
                                        <x-std::sidebar.menu-sub-button href="#"> Team </x-std::sidebar.menu-sub-button>
                                    </x-std::sidebar.menu-sub-item>
                                </x-std::sidebar.menu-sub>
                            </x-std::sidebar.menu-item>
                        </x-std::sidebar.menu>
                    </x-std::sidebar.group-content>
                </x-std::sidebar.group>

                <x-std::sidebar.separator />

                <x-std::sidebar.group>
                    <x-std::sidebar.group-label>Support</x-std::sidebar.group-label>
                    <x-std::sidebar.group-content>
                        <x-std::sidebar.menu>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Documentation">
                                    <x-std::icon name="clipboard" class="size-4" />
                                    <span>Documentation</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                        </x-std::sidebar.menu>
                    </x-std::sidebar.group-content>
                </x-std::sidebar.group>
            </x-std::sidebar.content>

            <x-std::sidebar.footer>
                <x-std::sidebar.menu>
                    <x-std::sidebar.menu-item>
                        <x-std::sidebar.menu-button href="#" tooltip="Olivia Martin">
                            <x-std::avatar name="Olivia Martin" size="sm" circle />
                            <span>Olivia Martin</span>
                        </x-std::sidebar.menu-button>
                    </x-std::sidebar.menu-item>
                </x-std::sidebar.menu>
            </x-std::sidebar.footer>

            <x-std::sidebar.rail />
        </x-std::sidebar>

        <x-std::sidebar.inset>
            <x-std::header>
                <div class="flex w-full items-center gap-2 px-4">
                    <x-std::sidebar.trigger />
                    <x-std::separator orientation="vertical" class="me-2 h-4!" />
                    <x-std::breadcrumb>
                        <x-std::breadcrumb.list>
                            <x-std::breadcrumb.item class="hidden md:block">
                                <x-std::breadcrumb.link href="#">Build your application</x-std::breadcrumb.link>
                            </x-std::breadcrumb.item>
                            <x-std::breadcrumb.separator class="hidden md:block" />
                            <x-std::breadcrumb.item>
                                <x-std::breadcrumb.page>Data fetching</x-std::breadcrumb.page>
                            </x-std::breadcrumb.item>
                        </x-std::breadcrumb.list>
                    </x-std::breadcrumb>
                    <div class="ms-auto hidden items-center gap-2 sm:flex">
                        <x-std::button variant="outline" size="sm">Search</x-std::button>
                        <x-std::button size="sm">New</x-std::button>
                    </div>
                </div>
            </x-std::header>

            <x-std::main>
                <x-std::text size="sm" variant="subtle">
                    Main content sits in <code class="font-mono text-xs">sidebar.inset</code> with
                    <code class="font-mono text-xs">header</code> and <code class="font-mono text-xs">main</code>.
                    Toggle with the trigger, rail edge, or
                    <kbd class="rounded border border-zinc-200 px-1 font-mono text-[10px] dark:border-zinc-700">⌘B</kbd
                    >.
                </x-std::text>
            </x-std::main>
        </x-std::sidebar.inset>
    </x-std::sidebar.provider>
</div>
