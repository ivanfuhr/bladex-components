@extends('workbench::layouts.playbook')

@section('title', 'Getting started — Std Components Docs')

@section('shell_breadcrumb')
    @include('workbench::playbook.partials.shell-breadcrumb', [
        'items' => [
            ['label' => 'Std Components Docs', 'href' => route('playbook.getting-started')],
            ['label' => 'Getting started', 'current' => true],
        ],
    ])
@endsection

@section('content')
    <div class="mx-auto max-w-3xl space-y-10">
        <header class="space-y-4">
            <x-std::badge variant="outline" rounded>Guide</x-std::badge>
            <x-std::heading :level="1">Getting started</x-std::heading>
            <x-std::text variant="subtle" class="max-w-prose text-base leading-7">
                Install Std Components, wire Tailwind and assets into your layout, then browse the component catalog for
                copy-paste examples and interactive previews.
            </x-std::text>
        </header>

        <section class="space-y-4" aria-labelledby="install-heading">
            <x-std::heading :level="2" id="install-heading" class="text-lg!">Installation</x-std::heading>
            <x-std::text variant="subtle">Add the package to your Laravel application.</x-std::text>
            <x-std::code-block language="bash"> composer require ivanfuhr/std-components </x-std::code-block>
            <x-std::text size="sm" variant="subtle">
                Optional config:
                <x-std::code-block
                    inline
                    language="bash"
                    code="php artisan vendor:publish --tag=std-components-config"
                />
            </x-std::text>
        </section>

        <section class="space-y-4" aria-labelledby="layout-heading">
            <x-std::heading :level="2" id="layout-heading" class="text-lg!">Layout &amp; assets</x-std::heading>
            <x-std::text variant="subtle">
                Add Std Components directives to your layout. Scripts and styles are served from the package by default.
            </x-std::text>
            <x-std::code-block language="html">
                @verbatim
<head>
    @stdStyles
    <x-std::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-std::input name="email" />
    @stdScripts
</body>
@endverbatim
            </x-std::code-block>
        </section>

        <section class="space-y-4" aria-labelledby="tailwind-heading">
            <x-std::heading :level="2" id="tailwind-heading" class="text-lg!">Tailwind CSS</x-std::heading>
            <x-std::text variant="subtle">
                Import the package entry in your app CSS. Dark mode uses a
                <x-std::code-block inline language="html" code=".dark" />
                class on
                <x-std::code-block inline language="html" code="&lt;html&gt;" />
                .
            </x-std::text>
            <x-std::code-block language="css">
                @import
                "tailwindcss";
                @import
                "../../vendor/ivanfuhr/std-components/resources/css/std-components.css";
            </x-std::code-block>
        </section>

        <section class="space-y-4" aria-labelledby="directives-heading">
            <x-std::heading :level="2" id="directives-heading" class="text-lg!">Directives</x-std::heading>
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
                            <td class="px-4 py-2.5">
                                <x-std::code-block inline language="blade" code="@@stdStyles" />
                            </td>
                            <td class="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">
                                Base CSS tokens and component layers
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5">
                                <x-std::code-block inline language="blade" code="@@stdScripts" />
                            </td>
                            <td class="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">
                                Vanilla JS runtime for interactive widgets
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="space-y-4" aria-labelledby="browse-heading">
            <x-std::heading :level="2" id="browse-heading" class="text-lg!">Browse components</x-std::heading>
            <x-std::text variant="subtle">
                Each component page includes usage examples, a live playground, and generated Blade snippets.
                Interactive widgets are powered by
                <x-std::code-block inline language="blade" code="@@stdScripts" />
                in your layout — no per-component JavaScript install step.
            </x-std::text>
            <div class="flex flex-wrap gap-2">
                <x-std::button href="{{ route('playbook.index') }}" variant="primary">Open catalog</x-std::button>
                <x-std::button href="{{ route('playbook.showcase') }}" variant="outline">View showcase</x-std::button>
            </div>
        </section>

        <section
            class="space-y-4 rounded-2xl border border-zinc-200/80 bg-zinc-50/80 p-6 dark:border-zinc-800 dark:bg-zinc-900/40"
            aria-labelledby="dev-heading"
        >
            <x-std::heading :level="2" id="dev-heading" class="text-lg!">Contributors</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Run the workbench from the repository root to preview changes locally.
            </x-std::text>
            <x-std::code-block language="bash">
                composer playbook # http://127.0.0.1:8000/playbook composer build composer serve
            </x-std::code-block>
        </section>
    </div>
@endsection
