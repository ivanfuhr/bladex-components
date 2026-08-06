@extends('workbench::layouts.playbook')

@section('title', 'Std Components Docs')

@section('content')
    <div class="space-y-12">
        <header class="space-y-6">
            <div class="space-y-4">
                <x-std::badge variant="outline" rounded>Documentation</x-std::badge>
                <div class="flex flex-wrap items-center gap-3">
                    <x-std::heading :level="1">Component catalog</x-std::heading>
                    <x-std::badge variant="outline" rounded>{{ $componentCount }} components</x-std::badge>
                </div>
                <x-std::text class="max-w-prose text-base leading-7 text-zinc-600 dark:text-zinc-400">
                    Browse
                    <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">x-std::*</code>
                    primitives with usage guides, live playgrounds, and copy-ready Blade snippets.
                </x-std::text>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-std::button href="{{ route('playbook.getting-started') }}" variant="primary">
                    Getting started
                </x-std::button>
                <x-std::dialog.trigger name="playbook-catalog-command">
                    <x-std::button variant="outline" class="gap-2 text-zinc-600 dark:text-zinc-400">
                        <x-std::icon name="search" class="size-4" />
                        <span>Search…</span>
                        <span class="hidden rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest sm:inline dark:border-zinc-700">
                            ⌘K
                        </span>
                    </x-std::button>
                </x-std::dialog.trigger>
            </div>
        </header>

        <x-std::command.dialog name="playbook-catalog-command" shortcut="meta.k">
            <x-std::command placeholder="Search components…">
                <x-std::command.group heading="Docs">
                    <x-std::command.item
                        value="getting-started"
                        href="{{ route('playbook.getting-started') }}"
                        icon="file"
                    >
                        Getting started
                    </x-std::command.item>
                    <x-std::command.item value="showcase" href="{{ route('playbook.showcase') }}" icon="star">
                        Event Studio showcase
                    </x-std::command.item>
                    <x-std::command.item value="catalog" href="{{ route('playbook.index') }}" icon="clipboard">
                        Component catalog
                    </x-std::command.item>
                </x-std::command.group>
                <x-std::command.separator />
                @foreach ($categories as $category)
                    <x-std::command.group :heading="$category['label']">
                        @foreach ($category['playbooks'] as $playbook)
                            <x-std::command.item
                                :value="$playbook->slug"
                                :href="route('playbook.show', $playbook->slug)"
                            >
                                {{ $playbook->title }}
                            </x-std::command.item>
                        @endforeach
                    </x-std::command.group>
                @endforeach
            </x-std::command>
        </x-std::command.dialog>

        <a
            href="{{ route('playbook.showcase') }}"
            class="group block rounded-xl focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
        >
            <x-std::card class="border-zinc-300 bg-zinc-50 transition duration-200 group-hover:-translate-y-0.5 group-hover:border-zinc-400 group-hover:shadow-md motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:border-zinc-700 dark:bg-zinc-900 dark:group-hover:border-zinc-600 dark:group-hover:bg-zinc-900/80">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0 space-y-2">
                        <x-std::badge variant="outline" rounded>Scenario</x-std::badge>
                        <x-std::heading :level="2">Event Studio showcase</x-std::heading>
                        <x-std::text size="sm" variant="subtle">
                            One screen composing every component in a realistic event-editor flow.
                        </x-std::text>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Open showcase
                        <x-std::icon
                            name="chevron-right"
                            class="size-4 transition group-hover:translate-x-0.5 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0"
                        />
                    </span>
                </div>
            </x-std::card>
        </a>

        <nav aria-label="Catalog sections" class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <x-std::badge :href="'#catalog-'.$category['key']" variant="outline" rounded class="gap-1.5">
                    {{ $category['label'] }}
                    <span class="text-zinc-400 tabular-nums dark:text-zinc-500">{{ count($category['playbooks']) }}</span>
                </x-std::badge>
            @endforeach
        </nav>

        <div class="space-y-14">
            @foreach ($categories as $category)
                <section aria-labelledby="catalog-{{ $category['key'] }}" class="scroll-mt-6">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <x-std::heading
                            :level="2"
                            id="catalog-{{ $category['key'] }}"
                            class="text-base! font-semibold tracking-tight"
                        >
                            {{ $category['label'] }}
                        </x-std::heading>
                        <x-std::badge variant="outline" rounded> {{ count($category['playbooks']) }} </x-std::badge>
                    </div>

                    <x-std::separator class="mb-5!" />

                    <x-std::grid sm="2" lg="3" gap="4" :container="false" class="w-full" role="list">
                        @foreach ($category['playbooks'] as $playbook)
                            <div role="listitem" class="min-w-0">
                                <a
                                    href="{{ route('playbook.show', $playbook->slug) }}"
                                    class="group block h-full rounded-xl focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
                                >
                                    <x-std::card class="h-full transition duration-200 group-hover:-translate-y-0.5 group-hover:border-zinc-300 group-hover:shadow-md motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:group-hover:border-zinc-600 dark:group-hover:bg-zinc-900">
                                        <x-std::card.header class="flex-1 space-y-3">
                                            <x-std::text
                                                size="sm"
                                                inline
                                                class="font-mono text-xs! text-zinc-500 dark:text-zinc-400"
                                            >
                                                x-std::{{ $playbook->slug }}
                                            </x-std::text>
                                            <x-std::card.title>{{ $playbook->title }}</x-std::card.title>
                                            <x-std::card.description class="line-clamp-2">
                                                {{ $playbook->description }}
                                            </x-std::card.description>
                                        </x-std::card.header>
                                        <x-std::card.footer class="mt-auto border-t-0 pt-0">
                                            <span class="inline-flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Read docs
                                                <x-std::icon
                                                    name="chevron-right"
                                                    class="size-4 transition group-hover:translate-x-0.5 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0"
                                                />
                                            </span>
                                        </x-std::card.footer>
                                    </x-std::card>
                                </a>
                            </div>
                        @endforeach
                    </x-std::grid>
                </section>
            @endforeach
        </div>
    </div>
@endsection
