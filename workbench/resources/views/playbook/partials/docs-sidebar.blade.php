@php
    $currentComponent = request()->route('component');
    $gettingStartedActive = request()->routeIs('playbook.getting-started');
    $catalogActive = request()->routeIs('playbook.index');
    $showcaseActive = request()->routeIs('playbook.showcase');
@endphp

<x-ui::sidebar.header class="border-b border-zinc-200/80 p-0 dark:border-zinc-800/80">
    <div class="flex h-14 items-center gap-2 px-2">
        <x-ui::sidebar.brand
            href="{{ route('playbook.getting-started') }}"
            name="Stencil Docs"
            class="group-data-[collapsible=icon]:justify-center"
        >
            <x-slot:logo>
                <span class="text-xs font-bold">S</span>
            </x-slot:logo>
        </x-ui::sidebar.brand>
    </div>
</x-ui::sidebar.header>

<x-ui::sidebar.content class="gap-0">
    <x-ui::sidebar.group class="py-2">
        <x-ui::sidebar.group-label>Guide</x-ui::sidebar.group-label>
        <x-ui::sidebar.group-content>
            <x-ui::sidebar.menu>
                <x-ui::sidebar.menu-item>
                    <x-ui::sidebar.menu-button
                        href="{{ route('playbook.getting-started') }}"
                        :active="$gettingStartedActive"
                        tooltip="Getting started"
                    >
                        <x-ui::icon name="file" class="size-4" />
                        <span>Getting started</span>
                    </x-ui::sidebar.menu-button>
                </x-ui::sidebar.menu-item>
                <x-ui::sidebar.menu-item>
                    <x-ui::sidebar.menu-button
                        href="{{ route('playbook.index') }}"
                        :active="$catalogActive"
                        tooltip="Components"
                    >
                        <x-ui::icon name="clipboard" class="size-4" />
                        <span>Components</span>
                    </x-ui::sidebar.menu-button>
                </x-ui::sidebar.menu-item>
                <x-ui::sidebar.menu-item>
                    <x-ui::sidebar.menu-button
                        href="{{ route('playbook.showcase') }}"
                        :active="$showcaseActive"
                        tooltip="Showcase"
                    >
                        <x-ui::icon name="star" class="size-4" />
                        <span>Showcase</span>
                    </x-ui::sidebar.menu-button>
                </x-ui::sidebar.menu-item>
            </x-ui::sidebar.menu>
        </x-ui::sidebar.group-content>
    </x-ui::sidebar.group>

    <x-ui::sidebar.separator />

    @foreach ($playbookRegistry->grouped() as $category)
        <x-ui::sidebar.group class="py-2">
            <x-ui::sidebar.group-label>{{ $category['label'] }}</x-ui::sidebar.group-label>
            <x-ui::sidebar.group-content>
                <x-ui::sidebar.menu>
                    @foreach ($category['playbooks'] as $playbook)
                        @php
                            $isActive = request()->routeIs('playbook.show') && $currentComponent === $playbook->slug;
                        @endphp
                        <x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-button
                                href="{{ route('playbook.show', $playbook->slug) }}"
                                :active="$isActive"
                                :tooltip="$playbook->title"
                                size="sm"
                            >
                                <span class="truncate">{{ $playbook->title }}</span>
                            </x-ui::sidebar.menu-button>
                        </x-ui::sidebar.menu-item>
                    @endforeach
                </x-ui::sidebar.menu>
            </x-ui::sidebar.group-content>
        </x-ui::sidebar.group>
    @endforeach
</x-ui::sidebar.content>
