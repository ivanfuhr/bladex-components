<!DOCTYPE html>
<html
    lang="en"
    class="h-full overflow-hidden antialiased"
    x-data="{
        dark: localStorage.getItem('std-playbook-dark') === '1',
    }"
    x-init="$watch('dark', (value) => localStorage.setItem('std-playbook-dark', value ? '1' : '0'))"
    x-bind:class="dark ? 'dark scheme-dark' : 'scheme-light'"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Std Components Docs')</title>
    <script>
        (function () {
            try {
                if (localStorage.getItem('std-playbook-dark') === '1') {
                    document.documentElement.classList.add('dark', 'scheme-dark');
                } else {
                    document.documentElement.classList.add('scheme-light');
                }
            } catch (e) {
                document.documentElement.classList.add('scheme-light');
            }
        })();
    </script>
    @stdStyles
    <x-std::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-svh overflow-hidden bg-zinc-100/90 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    @inject('playbookRegistry', 'Workbench\App\Playbook\PlaybookRegistry')

    @php
        $isShowcase = request()->routeIs('playbook.showcase');
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
        <x-std::sidebar.provider :default-open="true" storage-key="std-playbook-shell" class="h-svh">
            <x-std::sidebar collapsible="icon" class="shrink-0">
                @include('workbench::playbook.partials.docs-sidebar')

                <x-std::sidebar.spacer />

                <x-std::sidebar.footer class="border-t border-zinc-200/80 dark:border-zinc-800/80">
                    <div class="flex items-center justify-between gap-3 px-2 py-2 group-data-[collapsible=icon]:justify-center">
                        <span
                            class="truncate text-sm text-zinc-700 group-data-[collapsible=icon]:hidden dark:text-zinc-300"
                            x-text="dark ? 'Dark mode' : 'Light mode'"
                        ></span>
                        <x-std::switch
                            size="sm"
                            x-model.boolean="dark"
                            x-bind:aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
                        />
                    </div>
                </x-std::sidebar.footer>

                <x-std::sidebar.rail />
            </x-std::sidebar>

            <x-std::sidebar.inset>
                <x-std::header>
                    <div class="flex min-w-0 flex-1 items-center gap-2 px-4">
                        <x-std::sidebar.trigger />
                        <x-std::separator orientation="vertical" class="me-2 h-4!" />
                        @hasSection('shell_breadcrumb')
                            @yield('shell_breadcrumb')
                        @else
                            @include('workbench::playbook.partials.shell-breadcrumb', [
                                'items' => [
                                    ['label' => 'Std Components Docs', 'href' => route('playbook.getting-started')],
                                    ['label' => 'Components', 'current' => true],
                                ],
                            ])
                        @endif
                    </div>
                </x-std::header>

                <x-std::main
                    id="playbook-main"
                    tabindex="-1"
                    :container="true"
                    @class([trim($__env->yieldContent('main_class'))])
                >
                    @yield('content')
                </x-std::main>
            </x-std::sidebar.inset>
        </x-std::sidebar.provider>
    @endif
    {{--
        Do not load @stdScripts here. Vite already pulls widget modules via
        resources/js/app.js (playbook-preview side-effect imports). A second
        std-components.js copy would bind the same nodes again and break toggles
        (accordion/collapsible appear inert after Alpine x-html injection).
    --}}
</body>
</html>
