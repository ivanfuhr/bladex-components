@extends('workbench::playbook.media.layout')

@section('title', 'Sidebar — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::sidebar /&gt;</p>
            <x-std::heading :level="2">Sidebar</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                App-shell navigation with icon collapse, layout header, and inset main — inspired by shadcn sidebar-07.
            </x-std::text>
        </div>

        <div class="h-[28rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-std::sidebar.provider storage-key="std-media-sidebar" class="h-full min-h-0">
                <x-std::sidebar collapsible="icon">
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
                                        <x-std::sidebar.menu-button href="#" tooltip="Projects">
                                            <x-std::icon name="search" class="size-4" />
                                            <span>Projects</span>
                                        </x-std::sidebar.menu-button>
                                    </x-std::sidebar.menu-item>
                                    <x-std::sidebar.menu-item>
                                        <x-std::sidebar.menu-button href="#" tooltip="Settings">
                                            <x-std::icon name="clipboard" class="size-4" />
                                            <span>Settings</span>
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
                                    <x-std::breadcrumb.item>
                                        <x-std::breadcrumb.page>Dashboard</x-std::breadcrumb.page>
                                    </x-std::breadcrumb.item>
                                </x-std::breadcrumb.list>
                            </x-std::breadcrumb>
                        </div>
                    </x-std::header>
                    <x-std::main>
                        <x-std::text size="sm" variant="subtle">Inset content area for the active page.</x-std::text>
                    </x-std::main>
                </x-std::sidebar.inset>
            </x-std::sidebar.provider>
        </div>
    </div>
@endsection
