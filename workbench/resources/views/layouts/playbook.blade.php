<!DOCTYPE html>
<html
    lang="en"
    class="h-full antialiased"
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
<body class="min-h-full bg-zinc-100/90 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    <a
        href="#playbook-main"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-3 focus:py-2 focus:shadow-sm focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus:bg-zinc-900 dark:focus-visible:ring-zinc-300/20"
    >
        Skip to content
    </a>

    <header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-zinc-50/90 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-950/90">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-3.5 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-4">
                <a
                    href="{{ route('playbook.index') }}"
                    class="flex size-9 shrink-0 items-center justify-center rounded-lg border border-zinc-200 bg-white text-sm font-semibold tracking-tight text-zinc-900 shadow-sm transition hover:border-zinc-300 hover:bg-zinc-50 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-50 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                    aria-label="Stencil Playbook home"
                >
                    S
                </a>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <a
                            href="{{ route('playbook.index') }}"
                            class="truncate text-sm font-semibold tracking-tight text-zinc-950 focus-visible:rounded-sm focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                        >
                            Stencil Playbook
                        </a>
                        <span class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 text-[10px] font-medium tracking-wide text-zinc-500 uppercase dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400">
                            Workbench
                        </span>
                    </div>
                    <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                        Interactive component previews for local development
                    </p>
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                @php
                    $catalogActive = request()->routeIs('playbook.index', 'playbook.show');
                    $showcaseActive = request()->routeIs('playbook.showcase');
                    $navActive = 'rounded-lg border px-3 py-2 text-xs font-medium shadow-sm transition focus-visible:ring-2 focus-visible:outline-none border-zinc-900 bg-zinc-900 text-zinc-50 hover:bg-zinc-800 focus-visible:ring-zinc-950/20 dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-950 dark:hover:bg-white dark:focus-visible:ring-zinc-300/30';
                    $navIdle = 'rounded-lg border px-3 py-2 text-xs font-medium shadow-sm transition focus-visible:ring-2 focus-visible:outline-none border-zinc-200 bg-white text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 focus-visible:ring-zinc-950/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20';
                @endphp
                <nav aria-label="Playbook" class="flex items-center gap-2">
                    <a
                        href="{{ route('playbook.index') }}"
                        class="{{ $catalogActive ? $navActive : $navIdle }}"
                        @if ($catalogActive) aria-current="page" @endif
                    >Catalog</a>
                    <a
                        href="{{ route('playbook.showcase') }}"
                        class="{{ $showcaseActive ? $navActive : $navIdle }}"
                        @if ($showcaseActive) aria-current="page" @endif
                    >Showcase</a>
                </nav>
                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-medium text-zinc-700 shadow-sm transition focus-within:ring-2 focus-within:ring-zinc-950/10 hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:focus-within:ring-zinc-300/20 dark:hover:border-zinc-600">
                    <span class="sr-only">Dark mode</span>
                    <span class="hidden sm:inline" aria-hidden="true">Dark mode</span>
                    <input
                        type="checkbox"
                        role="switch"
                        class="size-4 rounded border-zinc-300 text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20"
                        x-model="dark"
                        x-bind:aria-checked="dark.toString()"
                    />
                </label>
            </div>
        </div>
    </header>

    <main id="playbook-main" tabindex="-1" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        @yield('content')
    </main>
    {{--
        Do not load @stencilScripts here. Vite already pulls widget modules via
        resources/js/app.js (playbook-preview side-effect imports). A second
        stencil.js copy would bind the same nodes again and break toggles
        (accordion/collapsible appear inert after Alpine x-html injection).
    --}}
</body>
</html>
