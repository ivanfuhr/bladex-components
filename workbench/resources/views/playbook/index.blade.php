@extends('workbench::layouts.playbook')

@section('title', 'Stencil Docs')

@section('content')
    <div class="space-y-12">
        <header class="space-y-6">
            <div class="space-y-4">
                <x-ui::badge variant="outline" rounded>Documentation</x-ui::badge>
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui::heading :level="1">Component catalog</x-ui::heading>
                    <x-ui::badge variant="outline" rounded>{{ $componentCount }} components</x-ui::badge>
                </div>
                <x-ui::text class="max-w-prose text-base leading-7 text-zinc-600 dark:text-zinc-400">
                    Browse
                    <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">x-ui::*</code>
                    primitives with usage guides, live playgrounds, and copy-ready Blade snippets.
                </x-ui::text>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-ui::button href="{{ route('playbook.getting-started') }}" variant="primary">
                    Getting started
                </x-ui::button>
                <x-ui::dialog.trigger name="playbook-catalog-command">
                    <x-ui::button variant="outline" class="gap-2 text-zinc-600 dark:text-zinc-400">
                        <x-ui::icon name="search" class="size-4" />
                        <span>Search…</span>
                        <span class="hidden rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest sm:inline dark:border-zinc-700">
                            ⌘K
                        </span>
                    </x-ui::button>
                </x-ui::dialog.trigger>
            </div>
        </header>

        <x-ui::command.dialog name="playbook-catalog-command" shortcut="meta.k">
            <x-ui::command placeholder="Search components…">
                <x-ui::command.group heading="Docs">
                    <x-ui::command.item
                        value="getting-started"
                        href="{{ route('playbook.getting-started') }}"
                        icon="file"
                    >
                        Getting started
                    </x-ui::command.item>
                    <x-ui::command.item value="showcase" href="{{ route('playbook.showcase') }}" icon="star">
                        Event Studio showcase
                    </x-ui::command.item>
                    <x-ui::command.item value="catalog" href="{{ route('playbook.index') }}" icon="clipboard">
                        Component catalog
                    </x-ui::command.item>
                </x-ui::command.group>
                <x-ui::command.separator />
                @foreach ($categories as $category)
                    <x-ui::command.group :heading="$category['label']">
                        @foreach ($category['playbooks'] as $playbook)
                            <x-ui::command.item
                                :value="$playbook->slug"
                                :href="route('playbook.show', $playbook->slug)"
                            >
                                {{ $playbook->title }}
                            </x-ui::command.item>
                        @endforeach
                    </x-ui::command.group>
                @endforeach
            </x-ui::command>
        </x-ui::command.dialog>

        <a
            href="{{ route('playbook.showcase') }}"
            class="group block rounded-xl focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
        >
            <x-ui::card
                class="border-zinc-300 bg-zinc-50 transition duration-200 group-hover:-translate-y-0.5 group-hover:border-zinc-400 group-hover:shadow-md motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:border-zinc-700 dark:bg-zinc-900 dark:group-hover:border-zinc-600 dark:group-hover:bg-zinc-900/80"
            >
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0 space-y-2">
                        <x-ui::badge variant="outline" rounded>Scenario</x-ui::badge>
                        <x-ui::heading :level="2">Event Studio showcase</x-ui::heading>
                        <x-ui::text size="sm" variant="subtle">
                            One screen composing every component in a realistic event-editor flow.
                        </x-ui::text>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Open showcase
                        <x-ui::icon
                            name="chevron-right"
                            class="size-4 transition group-hover:translate-x-0.5 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0"
                        />
                    </span>
                </div>
            </x-ui::card>
        </a>

        <nav aria-label="Catalog sections" class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <x-ui::badge :href="'#catalog-'.$category['key']" variant="outline" rounded class="gap-1.5">
                    {{ $category['label'] }}
                    <span class="text-zinc-400 tabular-nums dark:text-zinc-500">{{ count($category['playbooks']) }}</span>
                </x-ui::badge>
            @endforeach
        </nav>

        <div class="space-y-14">
            @foreach ($categories as $category)
                <section aria-labelledby="catalog-{{ $category['key'] }}" class="scroll-mt-6">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <x-ui::heading
                            :level="2"
                            id="catalog-{{ $category['key'] }}"
                            class="text-base! font-semibold tracking-tight"
                        >
                            {{ $category['label'] }}
                        </x-ui::heading>
                        <x-ui::badge variant="outline" rounded> {{ count($category['playbooks']) }} </x-ui::badge>
                    </div>

                    <x-ui::separator class="mb-5!" />

                    <x-ui::grid sm="2" lg="3" gap="4" :container="false" class="w-full" role="list">
                        @foreach ($category['playbooks'] as $playbook)
                            <div role="listitem" class="min-w-0">
                                <a
                                    href="{{ route('playbook.show', $playbook->slug) }}"
                                    class="group block h-full rounded-xl focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
                                >
                                    <x-ui::card class="h-full transition duration-200 group-hover:-translate-y-0.5 group-hover:border-zinc-300 group-hover:shadow-md motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:group-hover:border-zinc-600 dark:group-hover:bg-zinc-900">
                                        <x-ui::card.header class="flex-1 space-y-3">
                                            <x-ui::text
                                                size="sm"
                                                inline
                                                class="font-mono text-xs! text-zinc-500 dark:text-zinc-400"
                                            >
                                                x-ui::{{ $playbook->slug }}
                                            </x-ui::text>
                                            <x-ui::card.title>{{ $playbook->title }}</x-ui::card.title>
                                            <x-ui::card.description class="line-clamp-2">
                                                {{ $playbook->description }}
                                            </x-ui::card.description>
                                        </x-ui::card.header>
                                        <x-ui::card.footer class="mt-auto border-t-0 pt-0">
                                            <span class="inline-flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Read docs
                                                <x-ui::icon
                                                    name="chevron-right"
                                                    class="size-4 transition group-hover:translate-x-0.5 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0"
                                                />
                                            </span>
                                        </x-ui::card.footer>
                                    </x-ui::card>
                                </a>
                            </div>
                        @endforeach
                    </x-ui::grid>
                </section>
            @endforeach
        </div>
    </div>
@endsection
