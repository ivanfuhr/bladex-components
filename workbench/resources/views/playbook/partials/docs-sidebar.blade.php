@php
    $currentComponent = request()->route('component');
    $gettingStartedActive = request()->routeIs('playbook.getting-started');
    $catalogActive = request()->routeIs('playbook.index');
    $showcaseActive = request()->routeIs('playbook.showcase');
@endphp

<x-std::sidebar.header class="border-b border-zinc-200/80 p-0 dark:border-zinc-800/80">
    <div class="flex h-14 items-center gap-2 px-2">
        <x-std::sidebar.brand
            href="{{ route('playbook.getting-started') }}"
            name="Std Components Docs"
            class="group-data-[collapsible=icon]:justify-center"
        >
            <x-slot:logo>
                <span class="text-xs font-bold">S</span>
            </x-slot:logo>
        </x-std::sidebar.brand>
    </div>
</x-std::sidebar.header>

<x-std::sidebar.content class="gap-0">
    <x-std::sidebar.group class="py-2">
        <x-std::sidebar.group-label>Guide</x-std::sidebar.group-label>
        <x-std::sidebar.group-content>
            <x-std::sidebar.menu>
                <x-std::sidebar.menu-item>
                    <x-std::sidebar.menu-button
                        href="{{ route('playbook.getting-started') }}"
                        :active="$gettingStartedActive"
                        tooltip="Getting started"
                    >
                        <x-std::icon name="file" class="size-4" />
                        <span>Getting started</span>
                    </x-std::sidebar.menu-button>
                </x-std::sidebar.menu-item>
                <x-std::sidebar.menu-item>
                    <x-std::sidebar.menu-button
                        href="{{ route('playbook.index') }}"
                        :active="$catalogActive"
                        tooltip="Components"
                    >
                        <x-std::icon name="clipboard" class="size-4" />
                        <span>Components</span>
                    </x-std::sidebar.menu-button>
                </x-std::sidebar.menu-item>
                <x-std::sidebar.menu-item>
                    <x-std::sidebar.menu-button
                        href="{{ route('playbook.showcase') }}"
                        :active="$showcaseActive"
                        tooltip="Showcase"
                    >
                        <x-std::icon name="star" class="size-4" />
                        <span>Showcase</span>
                    </x-std::sidebar.menu-button>
                </x-std::sidebar.menu-item>
            </x-std::sidebar.menu>
        </x-std::sidebar.group-content>
    </x-std::sidebar.group>

    <x-std::sidebar.separator />

    @foreach ($playbookRegistry->grouped() as $category)
        <x-std::sidebar.group class="py-2">
            <x-std::sidebar.group-label>{{ $category['label'] }}</x-std::sidebar.group-label>
            <x-std::sidebar.group-content>
                <x-std::sidebar.menu>
                    @foreach ($category['playbooks'] as $playbook)
                        @php
                            $isActive = request()->routeIs('playbook.show') && $currentComponent === $playbook->slug;
                        @endphp
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button
                                href="{{ route('playbook.show', $playbook->slug) }}"
                                :active="$isActive"
                                :tooltip="$playbook->title"
                                size="sm"
                            >
                                <span class="truncate">{{ $playbook->title }}</span>
                            </x-std::sidebar.menu-button>
                        </x-std::sidebar.menu-item>
                    @endforeach
                </x-std::sidebar.menu>
            </x-std::sidebar.group-content>
        </x-std::sidebar.group>
    @endforeach
</x-std::sidebar.content>
