@extends('workbench::playbook.media.layout')

@section('title', 'Sidebar — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::sidebar /&gt;</p>
            <x-ui::heading :level="2">Sidebar</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                App-shell navigation with icon collapse, layout header, and inset main — inspired by shadcn sidebar-07.
            </x-ui::text>
        </div>

        <div class="h-[28rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-ui::sidebar.provider storage-key="stencil-media-sidebar" class="h-full min-h-0">
                <x-ui::sidebar collapsible="icon">
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
                                        <x-ui::sidebar.menu-button href="#" tooltip="Projects">
                                            <x-ui::icon name="search" class="size-4" />
                                            <span>Projects</span>
                                        </x-ui::sidebar.menu-button>
                                    </x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-item>
                                        <x-ui::sidebar.menu-button href="#" tooltip="Settings">
                                            <x-ui::icon name="clipboard" class="size-4" />
                                            <span>Settings</span>
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
                                    <x-ui::breadcrumb.item>
                                        <x-ui::breadcrumb.page>Dashboard</x-ui::breadcrumb.page>
                                    </x-ui::breadcrumb.item>
                                </x-ui::breadcrumb.list>
                            </x-ui::breadcrumb>
                        </div>
                    </x-ui::header>
                    <x-ui::main>
                        <x-ui::text size="sm" variant="subtle">Inset content area for the active page.</x-ui::text>
                    </x-ui::main>
                </x-ui::sidebar.inset>
            </x-ui::sidebar.provider>
        </div>
    </div>
@endsection
