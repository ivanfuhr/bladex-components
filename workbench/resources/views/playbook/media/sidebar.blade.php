@extends('workbench::playbook.media.layout')

@section('title', 'Sidebar — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::sidebar /&gt;</p>
            <x-ui::heading :level="2">Sidebar</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Composable app-shell navigation with collapse and mobile overlay.</x-ui::text>
        </div>

        <div class="h-[26rem] overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
            <x-ui::sidebar.provider storage-key="stencil-media-sidebar" class="min-h-full">
                <x-ui::sidebar collapsible="icon">
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
                                        <x-ui::sidebar.menu-button href="#" active> Home</x-ui::sidebar.menu-button>
                                    </x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-item>
                                        <x-ui::sidebar.menu-button href="#"> Projects</x-ui::sidebar.menu-button>
                                    </x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-item>
                                        <x-ui::sidebar.menu-button href="#"> Settings</x-ui::sidebar.menu-button>
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
                        <x-ui::text size="sm" variant="subtle">Inset content area for the active page.</x-ui::text>
                    </div>
                </x-ui::sidebar.inset>
            </x-ui::sidebar.provider>
        </div>
    </div>
@endsection
