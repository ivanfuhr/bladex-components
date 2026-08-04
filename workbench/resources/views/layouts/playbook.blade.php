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
    <title>@yield('title', 'Stencil Docs')</title>
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
        <x-ui::sidebar.provider :default-open="true" storage-key="stencil-playbook-shell" class="h-svh">
            <x-ui::sidebar collapsible="icon" class="shrink-0">
                @include('workbench::playbook.partials.docs-sidebar')

                <x-ui::sidebar.spacer />

                <x-ui::sidebar.footer class="border-t border-zinc-200/80 dark:border-zinc-800/80">
                    <div class="flex items-center justify-between gap-3 px-2 py-2 group-data-[collapsible=icon]:justify-center">
                        <span
                            class="truncate text-sm text-zinc-700 group-data-[collapsible=icon]:hidden dark:text-zinc-300"
                            x-text="dark ? 'Dark mode' : 'Light mode'"
                        ></span>
                        <x-ui::switch
                            size="sm"
                            x-model.boolean="dark"
                            x-bind:aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
                        />
                    </div>
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
                            @include('workbench::playbook.partials.shell-breadcrumb', [
                                'items' => [
                                    ['label' => 'Stencil Docs', 'href' => route('playbook.getting-started')],
                                    ['label' => 'Components', 'current' => true],
                                ],
                            ])
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
