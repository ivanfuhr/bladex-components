@extends('workbench::layouts.playbook')

@section('title', $playbook->title.' — Stencil Docs')

@section('shell_breadcrumb')
    <x-ui::breadcrumb>
        <x-ui::breadcrumb.list>
            <x-ui::breadcrumb.item class="hidden md:block">
                <x-ui::breadcrumb.link href="{{ route('playbook.index') }}">Stencil Docs</x-ui::breadcrumb.link>
            </x-ui::breadcrumb.item>
            <x-ui::breadcrumb.separator class="hidden md:block" />
            <x-ui::breadcrumb.item class="hidden md:block">
                <x-ui::breadcrumb.link href="{{ route('playbook.index') }}">Components</x-ui::breadcrumb.link>
            </x-ui::breadcrumb.item>
            <x-ui::breadcrumb.separator class="hidden md:block" />
            <x-ui::breadcrumb.item>
                <x-ui::breadcrumb.page>{{ $playbook->title }}</x-ui::breadcrumb.page>
            </x-ui::breadcrumb.item>
        </x-ui::breadcrumb.list>
    </x-ui::breadcrumb>
@endsection

@section('content')
    @php
        $defaultState = $playbook->defaultState;
        $sectionHeadingClass = 'text-sm font-semibold text-zinc-900 dark:text-zinc-100';
        $linkClass = 'rounded-sm text-sm font-medium text-zinc-600 transition hover:text-zinc-950 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20';
    @endphp

    <div
        class="space-y-10"
        x-data="playbookPreview({
            component: @js($playbook->slug),
            state: @js($defaultState),
            previewUrl: @js($previewUrl),
            initialHtml: @js($initialPreview),
            initialSnippet: @js($initialSnippet),
        })"
        x-init="init()"
    >
        <header class="space-y-4 border-b border-zinc-200/80 pb-8 dark:border-zinc-800">
            <div class="flex flex-wrap items-center gap-2">
                <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                    &lt;x-ui::<span class="text-zinc-800 dark:text-zinc-200">{{ $playbook->slug }}</span> /&gt;
                </p>
            </div>

            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0 space-y-3">
                    <x-ui::heading :level="1">{{ $playbook->title }}</x-ui::heading>
                    <x-ui::text class="max-w-prose text-base leading-7 text-zinc-600 dark:text-zinc-400">
                        {{ $playbook->description }}
                    </x-ui::text>
                </div>

                <nav class="flex shrink-0 flex-wrap items-center gap-3" aria-label="Page actions">
                    <a href="{{ route('playbook.index') }}" class="inline-flex items-center gap-1 {{ $linkClass }}">
                        <span aria-hidden="true">←</span>
                        Catalog
                    </a>
                    @if ($mediaUrl)
                        <a href="{{ $mediaUrl }}" class="{{ $linkClass }}">Screenshot</a>
                    @endif
                </nav>
            </div>

            @if ($installCommand)
                <div class="max-w-3xl">
                    @include('workbench::playbook.partials.install-callout', ['command' => $installCommand])
                </div>
            @endif
        </header>

        <div class="grid gap-10 xl:grid-cols-[minmax(0,1fr)_minmax(0,22rem)] xl:items-start xl:gap-12">
            <div class="min-w-0 space-y-10">
                @if ($guideHtml)
                    <section aria-labelledby="guide-heading">
                        <h2 id="guide-heading" class="{{ $sectionHeadingClass }}">Usage</h2>
                        <div class="mt-4">
                            @include('workbench::playbook.partials.guide-content', ['html' => $guideHtml])
                        </div>
                    </section>
                @endif

                <section aria-labelledby="playground-code-heading" x-show="snippet.length > 0">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 id="playground-code-heading" class="{{ $sectionHeadingClass }}">Playground output</h2>
                        <button
                            type="button"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-xs font-medium text-zinc-700 shadow-sm transition hover:border-zinc-300 hover:bg-zinc-50 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                            @click="copySnippet()"
                        >
                            <span x-text="copyLabel()"></span>
                        </button>
                    </div>
                    <div class="playbook-code mt-4 min-w-0 overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-50 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-white/5">
                        <pre class="playbook-code__pre max-h-[min(28rem,50vh)] overflow-auto p-4 font-mono text-xs leading-relaxed text-zinc-800 dark:text-zinc-200"><code class="playbook-code__content block whitespace-pre-wrap" x-text="snippet">{{ $initialSnippet }}</code></pre>
                    </div>
                </section>

                @if (count($playbook->controls) > 0)
                    <section aria-labelledby="playground-api-heading">
                        <h2 id="playground-api-heading" class="{{ $sectionHeadingClass }}">Playground properties</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            Tune the live preview using the controls in the sidebar.
                        </p>
                        <div class="mt-4">
                            @include('workbench::playbook.partials.playground-props-table', ['controls' => $playbook->controls])
                        </div>
                    </section>
                @endif
            </div>

            <aside class="space-y-6 xl:sticky xl:top-6" aria-label="Live preview and controls">
                <section aria-labelledby="playbook-preview-heading">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 id="playbook-preview-heading" class="{{ $sectionHeadingClass }}">Live preview</h2>
                        <p
                            class="text-xs text-zinc-500 dark:text-zinc-400"
                            aria-live="polite"
                            aria-atomic="true"
                            x-text="statusMessage"
                        ></p>
                    </div>

                    <div
                        id="playbook-canvas"
                        class="playbook-stage mt-4 flex min-h-[min(20rem,45vh)] items-start justify-center overflow-visible rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm ring-1 ring-zinc-950/5 sm:p-8 dark:border-zinc-800 dark:bg-zinc-900/50 dark:ring-white/5"
                        x-bind:aria-busy="loading.toString()"
                    >
                        <div
                            @class([
                                'w-full',
                                'max-w-md' => ! $playbook->wide,
                                'max-w-5xl' => $playbook->wide,
                            ])
                            x-html="html"
                        ></div>
                    </div>

                    <p class="mt-3 text-sm text-red-600 dark:text-red-400" x-show="error" x-cloak x-text="error"></p>
                </section>

                @if (count($playbook->controls) > 0)
                    <section
                        class="rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
                        aria-labelledby="playbook-properties-heading"
                    >
                        <h2 id="playbook-properties-heading" class="{{ $sectionHeadingClass }}">Controls</h2>
                        <form class="mt-4 space-y-4" @submit.prevent>
                            @foreach ($playbook->controls as $control)
                                <div>
                                    @if ($control->type === 'checkbox')
                                        <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-transparent px-1 py-1.5 text-sm text-zinc-800 transition hover:bg-zinc-50 dark:text-zinc-200 dark:hover:bg-zinc-800/60">
                                            <x-ui::checkbox
                                                class="mt-0.5"
                                                x-model.boolean="state.{{ $control->key }}"
                                                @change="queuePreview()"
                                            />
                                            <span>{{ $control->label }}</span>
                                        </label>
                                    @elseif ($control->type === 'select')
                                        <label
                                            class="block text-sm font-medium text-zinc-800 dark:text-zinc-200"
                                            for="control-{{ $control->key }}"
                                        >
                                            {{ $control->label }}
                                        </label>
                                        <select
                                            id="control-{{ $control->key }}"
                                            class="mt-1.5 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus-visible:border-zinc-300 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus-visible:border-zinc-600 dark:focus-visible:ring-zinc-300/20"
                                            x-model="state.{{ $control->key }}"
                                            @change="queuePreview()"
                                        >
                                            @foreach ($control->options as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                        </form>
                    </section>
                @endif
            </aside>
        </div>

        @if ($previousPlaybook || $nextPlaybook)
            <nav
                class="flex items-stretch gap-4 border-t border-zinc-200/80 pt-8 dark:border-zinc-800"
                aria-label="Sibling components"
            >
                <div class="min-w-0 flex-1">
                    @if ($previousPlaybook)
                        <a
                            href="{{ route('playbook.show', $previousPlaybook->slug) }}"
                            class="group flex min-h-full flex-col gap-1 rounded-xl border border-zinc-200/80 bg-white p-4 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:hover:border-zinc-700"
                        >
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Previous</span>
                            <span class="truncate font-medium text-zinc-900 group-hover:text-zinc-950 dark:text-zinc-100">
                                {{ $previousPlaybook->title }}
                            </span>
                        </a>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    @if ($nextPlaybook)
                        <a
                            href="{{ route('playbook.show', $nextPlaybook->slug) }}"
                            class="group flex min-h-full flex-col items-end gap-1 rounded-xl border border-zinc-200/80 bg-white p-4 text-right transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:hover:border-zinc-700"
                        >
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Next</span>
                            <span class="truncate font-medium text-zinc-900 group-hover:text-zinc-950 dark:text-zinc-100">
                                {{ $nextPlaybook->title }}
                            </span>
                        </a>
                    @endif
                </div>
            </nav>
        @endif
    </div>
@endsection
