@extends('workbench::layouts.playbook')

@section('title', 'Getting started — Stencil Docs')

@section('shell_breadcrumb')
    <x-ui::breadcrumb>
        <x-ui::breadcrumb.list>
            <x-ui::breadcrumb.item class="hidden md:block">
                <x-ui::breadcrumb.link href="{{ route('playbook.getting-started') }}">
                    Stencil Docs</x-ui::breadcrumb.link>
            </x-ui::breadcrumb.item>
            <x-ui::breadcrumb.separator class="hidden md:block" />
            <x-ui::breadcrumb.item>
                <x-ui::breadcrumb.page>Getting started</x-ui::breadcrumb.page>
            </x-ui::breadcrumb.item>
        </x-ui::breadcrumb.list>
    </x-ui::breadcrumb>
@endsection

@section('content')
    <div class="mx-auto max-w-3xl space-y-10">
        <header class="space-y-4">
            <x-ui::badge variant="outline" rounded>Guide</x-ui::badge>
            <x-ui::heading :level="1">Getting started</x-ui::heading>
            <x-ui::text variant="subtle" class="max-w-prose text-base leading-7">
                Install Stencil, wire Tailwind and assets into your layout, then browse the component catalog for
                copy-paste examples and interactive previews.
            </x-ui::text>
        </header>

        <section class="space-y-4" aria-labelledby="install-heading">
            <x-ui::heading :level="2" id="install-heading" class="text-lg!">Installation</x-ui::heading>
            <x-ui::text variant="subtle">Add the package to your Laravel application.</x-ui::text>
            <pre class="overflow-x-auto rounded-xl border border-zinc-200/80 bg-zinc-50 p-4 font-mono text-xs leading-relaxed text-zinc-800 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:ring-white/5"><code>composer require ivanfuhr/stencil</code></pre>
            <x-ui::text size="sm" variant="subtle">
                Optional config:
                <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs dark:border-zinc-700 dark:bg-zinc-900">php artisan vendor:publish --tag=stencil-config</code>
            </x-ui::text>
        </section>

        <section class="space-y-4" aria-labelledby="layout-heading">
            <x-ui::heading :level="2" id="layout-heading" class="text-lg!">Layout &amp; assets</x-ui::heading>
            <x-ui::text variant="subtle">
                Add Stencil directives to your layout. Scripts and styles are served from the package by default.
            </x-ui::text>
            <pre
                class="overflow-x-auto rounded-xl border border-zinc-200/80 bg-zinc-50 p-4 font-mono text-xs leading-relaxed text-zinc-800 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:ring-white/5"
            ><code>&lt;head&gt;
    @@stencilStyles
    &lt;x-ui::fonts /&gt;
    @@vite(['resources/css/app.css', 'resources/js/app.js'])
&lt;/head&gt;
&lt;body&gt;
    &lt;x-ui::input name="email" /&gt;
    @@stencilScripts
&lt;/body&gt;</code></pre>
        </section>

        <section class="space-y-4" aria-labelledby="tailwind-heading">
            <x-ui::heading :level="2" id="tailwind-heading" class="text-lg!">Tailwind CSS</x-ui::heading>
            <x-ui::text variant="subtle">
                Import the package entry in your app CSS. Dark mode uses a
                <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs dark:border-zinc-700 dark:bg-zinc-900">.dark</code>
                class on
                <code
                    class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs dark:border-zinc-700 dark:bg-zinc-900"
                    >&lt;html&gt;</code
                >.
            </x-ui::text>
            <pre
                class="overflow-x-auto rounded-xl border border-zinc-200/80 bg-zinc-50 p-4 font-mono text-xs leading-relaxed text-zinc-800 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:ring-white/5"
            ><code>@@import "tailwindcss";
@@import "../../vendor/ivanfuhr/stencil/resources/css/stencil.css";</code></pre>
        </section>

        <section class="space-y-4" aria-labelledby="directives-heading">
            <x-ui::heading :level="2" id="directives-heading" class="text-lg!">Directives</x-ui::heading>
            <div class="overflow-hidden rounded-xl border border-zinc-200/80 dark:border-zinc-800">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-zinc-200/80 bg-zinc-50/80 dark:border-zinc-800 dark:bg-zinc-900/60">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 font-semibold">Directive</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold">Purpose</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200/80 dark:divide-zinc-800">
                        <tr>
                            <td class="px-4 py-2.5 font-mono text-xs">@@stencilStyles</td>
                            <td class="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">
                                Base CSS tokens and component layers
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 font-mono text-xs">@@stencilScripts</td>
                            <td class="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">
                                Vanilla JS runtime for interactive widgets
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="space-y-4" aria-labelledby="browse-heading">
            <x-ui::heading :level="2" id="browse-heading" class="text-lg!">Browse components</x-ui::heading>
            <x-ui::text variant="subtle">
                Each component page includes usage examples, a live playground, and generated Blade snippets.
                Interactive widgets list their
                <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs dark:border-zinc-700 dark:bg-zinc-900">stencil:add</code>
                install command when a JavaScript module is required.
            </x-ui::text>
            <div class="flex flex-wrap gap-2">
                <x-ui::button href="{{ route('playbook.index') }}" variant="primary">Open catalog</x-ui::button>
                <x-ui::button href="{{ route('playbook.showcase') }}" variant="outline">View showcase</x-ui::button>
            </div>
        </section>

        <section
            class="space-y-4 rounded-2xl border border-zinc-200/80 bg-zinc-50/80 p-6 dark:border-zinc-800 dark:bg-zinc-900/40"
            aria-labelledby="dev-heading"
        >
            <x-ui::heading :level="2" id="dev-heading" class="text-lg!">Contributors</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Run the workbench from the repository root to preview changes locally.
            </x-ui::text>
            <pre
                class="overflow-x-auto rounded-xl border border-zinc-200/80 bg-white p-4 font-mono text-xs leading-relaxed text-zinc-800 shadow-sm dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200"
            ><code>composer playbook   # http://127.0.0.1:8000/playbook
composer build
composer serve</code></pre>
        </section>
    </div>
@endsection
