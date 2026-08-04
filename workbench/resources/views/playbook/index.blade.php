@extends('workbench::layouts.playbook')

@section('title', 'Stencil Playbook')

@section('content')
    @php
        $componentCount = collect($categories)->sum(fn (array $category): int => count($category['playbooks']));
    @endphp

    <div class="space-y-10">
        <x-ui::header variant="page" :border="false">
            <div class="min-w-0 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui::heading :level="1">Component catalog</x-ui::heading>
                    <x-ui::badge variant="outline" rounded>{{ $componentCount }} components</x-ui::badge>
                </div>
                <x-ui::text variant="subtle" class="max-w-prose">
                    Tune props on live
                    <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">x-ui::*</code>
                    previews. Start the workbench with
                    <code class="rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">composer serve</code>
                    from the repository root.
                </x-ui::text>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-ui::dialog.trigger name="playbook-catalog-command">
                    <x-ui::button variant="outline" class="gap-2 text-zinc-500 dark:text-zinc-400">
                        <x-ui::icon name="search" class="size-4" />
                        <span>Search components…</span>
                        <span
                            class="hidden rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest sm:inline dark:border-zinc-700"
                        >
                            ⌘K
                        </span>
                    </x-ui::button>
                </x-ui::dialog.trigger>
            </div>
        </x-ui::header>

        <x-ui::command.dialog name="playbook-catalog-command" shortcut="meta.k">
            <x-ui::command placeholder="Search components…">
                <x-ui::command.group heading="Surfaces">
                    <x-ui::command.item
                        value="showcase"
                        href="{{ route('playbook.showcase') }}"
                        icon="star"
                    >
                        Event Studio showcase
                    </x-ui::command.item>
                    <x-ui::command.item
                        value="catalog"
                        href="{{ route('playbook.index') }}"
                        icon="file"
                    >
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

        <nav aria-label="Catalog sections" class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <x-ui::badge
                    :href="'#catalog-'.$category['key']"
                    variant="outline"
                    rounded
                    class="gap-1.5"
                >
                    {{ $category['label'] }}
                    <span class="tabular-nums text-zinc-400 dark:text-zinc-500">{{ count($category['playbooks']) }}</span>
                </x-ui::badge>
            @endforeach
        </nav>

        <a
            href="{{ route('playbook.showcase') }}"
            class="group block rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/20 dark:focus-visible:ring-zinc-300/30"
        >
            <x-ui::card
                class="border-zinc-900 bg-zinc-900 text-zinc-50 transition duration-200 group-hover:-translate-y-0.5 group-hover:bg-zinc-800 motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-950 dark:group-hover:bg-white"
            >
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0 space-y-2">
                        <x-ui::badge
                            variant="outline"
                            rounded
                            class="border-zinc-700 bg-zinc-800 text-zinc-300 dark:border-zinc-300 dark:bg-zinc-200 dark:text-zinc-700"
                        >
                            Scenario
                        </x-ui::badge>
                        <x-ui::heading :level="2" class="text-zinc-50! dark:text-zinc-950!">
                            Event Studio showcase
                        </x-ui::heading>
                        <x-ui::text size="sm" class="text-zinc-300 dark:text-zinc-600">
                            One screen composing every component in a realistic event-editor flow.
                        </x-ui::text>
                    </div>
                    <span
                        class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-zinc-50 dark:text-zinc-950"
                    >
                        Open showcase
                        <x-ui::icon
                            name="chevron-right"
                            class="size-4 transition group-hover:translate-x-0.5 motion-reduce:transition-none motion-reduce:group-hover:translate-x-0"
                        />
                    </span>
                </div>
            </x-ui::card>
        </a>

        <div class="space-y-12">
            @foreach ($categories as $category)
                <section aria-labelledby="catalog-{{ $category['key'] }}" class="scroll-mt-6">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <x-ui::heading
                            :level="2"
                            id="catalog-{{ $category['key'] }}"
                            class="text-sm! font-semibold tracking-tight"
                        >
                            {{ $category['label'] }}
                        </x-ui::heading>
                        <x-ui::badge variant="outline" rounded>
                            {{ count($category['playbooks']) }}
                            {{ count($category['playbooks']) === 1 ? 'component' : 'components' }}
                        </x-ui::badge>
                    </div>

                    <x-ui::separator class="mb-4!" />

                    <x-ui::grid sm="2" gap="4" :container="false" class="w-full" role="list">
                        @foreach ($category['playbooks'] as $playbook)
                            <div role="listitem" class="min-w-0">
                                <a
                                    href="{{ route('playbook.show', $playbook->slug) }}"
                                    class="group block h-full rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20"
                                >
                                    <x-ui::card
                                        class="h-full transition duration-200 group-hover:-translate-y-0.5 group-hover:border-zinc-300 group-hover:shadow-md motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 dark:group-hover:border-zinc-600 dark:group-hover:bg-zinc-900"
                                    >
                                        <x-ui::card.header class="flex-1">
                                            <x-ui::text
                                                size="sm"
                                                inline
                                                class="font-mono text-xs! text-zinc-500 dark:text-zinc-400"
                                            >
                                                &lt;x-ui::<span class="text-zinc-800 dark:text-zinc-200">{{ $playbook->slug }}</span>
                                                /&gt;
                                            </x-ui::text>
                                            <x-ui::card.title class="mt-3">{{ $playbook->title }}</x-ui::card.title>
                                            <x-ui::card.description class="mt-2">
                                                {{ $playbook->description }}
                                            </x-ui::card.description>
                                        </x-ui::card.header>
                                        <x-ui::card.footer class="mt-auto">
                                            <span
                                                class="inline-flex items-center gap-1 text-sm font-medium text-zinc-900 dark:text-zinc-100"
                                            >
                                                Open playground
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
