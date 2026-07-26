<!DOCTYPE html>
<html lang="en" class="h-full antialiased" x-data="{ dark: true }" x-bind:class="dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BladeX Playbook')</title>
    <x-bladex-components::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-zinc-100/90 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    <a href="#playbook-main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-3 focus:py-2 focus:shadow-sm focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus:bg-zinc-900 dark:focus-visible:ring-zinc-300/20">
        Skip to content
    </a>

    <header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-zinc-50/90 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-950/90">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-3.5 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-4">
                <a
                    href="{{ route('playbook.index') }}"
                    class="flex size-9 shrink-0 items-center justify-center rounded-lg border border-zinc-200 bg-white text-sm font-semibold tracking-tight text-zinc-900 shadow-sm transition hover:border-zinc-300 hover:bg-zinc-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-50 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                    aria-label="BladeX Playbook home"
                >
                    BX
                </a>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('playbook.index') }}" class="truncate text-sm font-semibold tracking-tight text-zinc-950 dark:text-zinc-50">
                            BladeX Playbook
                        </a>
                        <span class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wide text-zinc-500 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400">
                            Workbench
                        </span>
                    </div>
                    <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                        Interactive component previews for local development
                    </p>
                </div>
            </div>

            <label class="flex shrink-0 cursor-pointer items-center gap-2.5 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-medium text-zinc-700 shadow-sm transition hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-zinc-600">
                <span class="hidden sm:inline">Dark preview</span>
                <input
                    type="checkbox"
                    class="size-4 rounded border-zinc-300 text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20"
                    x-model="dark"
                >
            </label>
        </div>
    </header>

    <main id="playbook-main" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        @yield('content')
    </main>
</body>
</html>
