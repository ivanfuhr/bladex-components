@extends('workbench::playbook.media.layout')

@section('title', 'Sidebar — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::sidebar /&gt;</p>
            <x-stencil::heading :level="2">Sidebar</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Composable app-shell navigation with collapse and mobile overlay.</x-stencil::text>
        </div>

        <div class="h-[26rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-stencil::sidebar.provider storage-key="stencil-media-sidebar" class="min-h-full">
                <x-stencil::sidebar collapsible="icon">
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
                                        <x-stencil::sidebar.menu-button href="#" active>Home</x-stencil::sidebar.menu-button>
                                    </x-stencil::sidebar.menu-item>
                                    <x-stencil::sidebar.menu-item>
                                        <x-stencil::sidebar.menu-button href="#">Projects</x-stencil::sidebar.menu-button>
                                    </x-stencil::sidebar.menu-item>
                                    <x-stencil::sidebar.menu-item>
                                        <x-stencil::sidebar.menu-button href="#">Settings</x-stencil::sidebar.menu-button>
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
                        <x-stencil::text size="sm" variant="subtle">Inset content area for the active page.</x-stencil::text>
                    </div>
                </x-stencil::sidebar.inset>
            </x-stencil::sidebar.provider>
        </div>
    </div>
@endsection
