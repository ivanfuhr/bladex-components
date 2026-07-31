@extends('workbench::layouts.playbook')

@section('title', 'Stencil Playbook')

@section('content')
    <div class="space-y-10">
        <header class="max-w-2xl space-y-3">
            <x-stencil::heading :level="1"> Component catalog </x-stencil::heading>
            <x-stencil::text variant="subtle" class="max-w-prose">
                Tune props and see rendered output from the package namespace. Start the app with
                <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">composer serve</code>
                from the repository root.
            </x-stencil::text>
        </header>

        <ul class="grid gap-4 sm:grid-cols-2 xl:grid-cols-2">
            @foreach ($playbooks as $playbook)
                <li>
                    <a
                        href="{{ route('playbook.show', $playbook->slug) }}"
                        class="group flex h-full flex-col rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:shadow-md focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:border-zinc-800 dark:bg-zinc-900/80 dark:hover:border-zinc-600 dark:hover:bg-zinc-900 dark:focus-visible:ring-zinc-300/20"
                    >
                        <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                            &lt;x-ui::<span class="text-zinc-800 dark:text-zinc-200">{{ $playbook->slug }}</span> /&gt;
                        </p>
                        <x-stencil::heading :level="2" class="mt-4"> {{ $playbook->title }} </x-stencil::heading>
                        <x-stencil::text size="sm" variant="subtle" class="mt-2 flex-1">
                            {{ $playbook->description }}
                        </x-stencil::text>
                        <span class="mt-5 inline-flex items-center text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Open playground
                            <span class="ml-1 transition group-hover:translate-x-0.5" aria-hidden="true">→</span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
