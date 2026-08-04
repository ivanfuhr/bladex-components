<!DOCTYPE html>
<html
    lang="en"
    class="h-full overflow-hidden antialiased"
    x-data="{
        dark: localStorage.getItem('stencil-playbook-dark') === '1',
    }"
    x-init="$watch('dark', (value) => localStorage.setItem('stencil-playbook-dark', value ? '1' : '0'))"
    x-bind:class="dark ? 'dark scheme-dark' : 'scheme-light'"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Stencil Playbook')</title>
    <script>
        (function () {
            try {
                if (localStorage.getItem('stencil-playbook-dark') === '1') {
                    document.documentElement.classList.add('dark', 'scheme-dark');
                } else {
                    document.documentElement.classList.add('scheme-light');
                }
            } catch (e) {
                document.documentElement.classList.add('scheme-light');
            }
        })();
    </script>
    @stencilStyles
    <x-ui::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-svh overflow-hidden bg-zinc-100/90 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    @inject('playbookRegistry', 'Workbench\App\Playbook\PlaybookRegistry')

    @php
        $catalogActive = request()->routeIs('playbook.index', 'playbook.show');
        $showcaseActive = request()->routeIs('playbook.showcase');
        $isShowcase = request()->routeIs('playbook.showcase');
        $projectCategories = collect($playbookRegistry->grouped())->take(3);
    @endphp

    <a
        href="#playbook-main"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-3 focus:py-2 focus:shadow-sm focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus:bg-zinc-900 dark:focus-visible:ring-zinc-300/20"
    >
        Skip to content
    </a>

    @if ($isShowcase)
        @yield('content')
    @else
        <x-ui::sidebar.provider :default-open="true" storage-key="stencil-playbook-shell" class="h-svh">
            <x-ui::sidebar collapsible="icon" class="shrink-0">
                <x-ui::sidebar.header>
                    <x-ui::sidebar.menu>
                        <x-ui::sidebar.menu-item>
                            <x-ui::dropdown-menu side="right" align="start">
                                <x-ui::dropdown-menu.trigger>
                                    <x-ui::sidebar.menu-button
                                        size="lg"
                                        class="data-[state=open]:bg-zinc-100 dark:data-[state=open]:bg-zinc-800"
                                    >
                                        <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-xs font-bold text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">
                                            S
                                        </span>
                                        <div class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                            <span class="truncate font-semibold">Stencil Playbook</span>
                                            <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">Workbench</span>
                                        </div>
                                        <x-ui::icon
                                            name="chevron-down"
                                            class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                        />
                                    </x-ui::sidebar.menu-button>
                                </x-ui::dropdown-menu.trigger>
                                <x-ui::dropdown-menu.content class="min-w-56">
                                    <x-ui::dropdown-menu.label>Surfaces</x-ui::dropdown-menu.label>
                                    <x-ui::dropdown-menu.item href="{{ route('playbook.index') }}">
                                        Component catalog
                                    </x-ui::dropdown-menu.item>
                                    <x-ui::dropdown-menu.item href="{{ route('playbook.showcase') }}">
                                        Event Studio showcase
                                    </x-ui::dropdown-menu.item>
                                </x-ui::dropdown-menu.content>
                            </x-ui::dropdown-menu>
                        </x-ui::sidebar.menu-item>
                    </x-ui::sidebar.menu>
                </x-ui::sidebar.header>

                <x-ui::sidebar.content>
                    <x-ui::sidebar.group>
                        <x-ui::sidebar.group-label>Platform</x-ui::sidebar.group-label>
                        <x-ui::sidebar.group-content>
                            <x-ui::sidebar.menu>
                                <x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-button
                                        href="{{ route('playbook.index') }}"
                                        :active="$catalogActive"
                                    >
                                        <x-ui::icon name="file" class="size-4" />
                                        <span>Catalog</span>
                                    </x-ui::sidebar.menu-button>
                                </x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-button
                                        href="{{ route('playbook.showcase') }}"
                                        :active="$showcaseActive"
                                    >
                                        <x-ui::icon name="star" class="size-4" />
                                        <span>Showcase</span>
                                    </x-ui::sidebar.menu-button>
                                </x-ui::sidebar.menu-item>
                            </x-ui::sidebar.menu>
                        </x-ui::sidebar.group-content>
                    </x-ui::sidebar.group>

                    <x-ui::sidebar.group>
                        <x-ui::sidebar.group-label>Projects</x-ui::sidebar.group-label>
                        <x-ui::sidebar.group-content>
                            <x-ui::sidebar.menu>
                                @foreach ($projectCategories as $category)
                                    <x-ui::sidebar.menu-item>
                                        <x-ui::sidebar.menu-button href="{{ route('playbook.index') }}#catalog-{{ $category['key'] }}">
                                            <x-ui::icon name="clipboard" class="size-4" />
                                            <span>{{ $category['label'] }}</span>
                                        </x-ui::sidebar.menu-button>
                                    </x-ui::sidebar.menu-item>
                                @endforeach
                                <x-ui::sidebar.menu-item>
                                    <x-ui::sidebar.menu-button href="{{ route('playbook.index') }}">
                                        <x-ui::icon name="plus" class="size-4" />
                                        <span>More</span>
                                    </x-ui::sidebar.menu-button>
                                </x-ui::sidebar.menu-item>
                            </x-ui::sidebar.menu>
                        </x-ui::sidebar.group-content>
                    </x-ui::sidebar.group>
                </x-ui::sidebar.content>

                <x-ui::sidebar.spacer />

                <x-ui::sidebar.footer>
                    <x-ui::sidebar.menu>
                        <x-ui::sidebar.menu-item>
                            <x-ui::dropdown-menu side="top" align="start">
                                <x-ui::dropdown-menu.trigger>
                                    <x-ui::sidebar.menu-button
                                        size="lg"
                                        class="data-[state=open]:bg-zinc-100 dark:data-[state=open]:bg-zinc-800"
                                    >
                                        <x-ui::avatar name="Ivan Führ" size="sm" circle />
                                        <div class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                            <span class="truncate font-semibold">Ivan Führ</span>
                                            <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                                @ivanfuhr
                                            </span>
                                        </div>
                                        <x-ui::icon
                                            name="chevron-down"
                                            class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                        />
                                    </x-ui::sidebar.menu-button>
                                </x-ui::dropdown-menu.trigger>
                                <x-ui::dropdown-menu.content class="min-w-56">
                                    <x-ui::dropdown-menu.label>Appearance</x-ui::dropdown-menu.label>
                                    <label class="flex cursor-pointer items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-zinc-700 dark:text-zinc-300">
                                        <input
                                            type="checkbox"
                                            role="switch"
                                            class="size-4 rounded border-zinc-300 text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20"
                                            x-model="dark"
                                            x-bind:aria-checked="dark.toString()"
                                        />
                                        <span>Dark mode</span>
                                    </label>
                                </x-ui::dropdown-menu.content>
                            </x-ui::dropdown-menu>
                        </x-ui::sidebar.menu-item>
                    </x-ui::sidebar.menu>
                </x-ui::sidebar.footer>

                <x-ui::sidebar.rail />
            </x-ui::sidebar>

            <x-ui::sidebar.inset>
                <x-ui::header>
                    <div class="flex min-w-0 flex-1 items-center gap-2 px-4">
                        <x-ui::sidebar.trigger />
                        <x-ui::separator orientation="vertical" class="me-2 h-4!" />
                        @hasSection('shell_breadcrumb')
                            @yield('shell_breadcrumb')
                        @else
                            <x-ui::breadcrumb>
                                <x-ui::breadcrumb.list>
                                    <x-ui::breadcrumb.item class="hidden md:block">
                                        <x-ui::breadcrumb.link href="{{ route('playbook.index') }}">
                                            Stencil Playbook
                                        </x-ui::breadcrumb.link>
                                    </x-ui::breadcrumb.item>
                                    <x-ui::breadcrumb.separator class="hidden md:block" />
                                    <x-ui::breadcrumb.item>
                                        <x-ui::breadcrumb.page>Catalog</x-ui::breadcrumb.page>
                                    </x-ui::breadcrumb.item>
                                </x-ui::breadcrumb.list>
                            </x-ui::breadcrumb>
                        @endif
                    </div>
                </x-ui::header>

                <x-ui::main
                    id="playbook-main"
                    tabindex="-1"
                    :container="true"
                    @class([trim($__env->yieldContent('main_class'))])
                >
                    @yield('content')
                </x-ui::main>
            </x-ui::sidebar.inset>
        </x-ui::sidebar.provider>
    @endif
    {{--
        Do not load @stencilScripts here. Vite already pulls widget modules via
        resources/js/app.js (playbook-preview side-effect imports). A second
        stencil.js copy would bind the same nodes again and break toggles
        (accordion/collapsible appear inert after Alpine x-html injection).
    --}}
</body>
</html>
