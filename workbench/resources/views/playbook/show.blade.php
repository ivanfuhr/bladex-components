@extends('workbench::layouts.playbook')

@section('title', $playbook->title.' — Stencil Playbook')

@section('content')
    @php
        $defaultState = $playbook->defaultState;
    @endphp

    <div
        class="grid gap-8 lg:grid-cols-[minmax(0,18rem)_minmax(0,1fr)] lg:gap-10 xl:grid-cols-[minmax(0,20rem)_minmax(0,1fr)]"
        x-data="playbookPreview({
            component: @js($playbook->slug),
            state: @js($defaultState),
            previewUrl: @js($previewUrl),
            initialHtml: @js($initialPreview),
            initialSnippet: @js($initialSnippet),
        })"
        x-init="init()"
    >
        <aside class="lg:sticky lg:top-24 lg:self-start" aria-label="Component controls">
            <nav class="mb-6">
                <a
                    href="{{ route('playbook.index') }}"
                    class="inline-flex items-center gap-1 text-sm font-medium text-zinc-600 transition hover:text-zinc-950 dark:text-zinc-400 dark:hover:text-zinc-50"
                >
                    <span aria-hidden="true">←</span>
                    Catalog
                </a>
            </nav>

            <div class="space-y-2">
                <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                    &lt;x-ui::<span class="text-zinc-800 dark:text-zinc-200">{{ $playbook->slug }}</span> /&gt;
                </p>
                <x-stencil::heading :level="1">
                    {{ $playbook->title }}
                </x-stencil::heading>
                <x-stencil::text size="sm" variant="subtle" class="max-w-prose">
                    {{ $playbook->description }}
                </x-stencil::text>
            </div>

            <div class="mt-8 rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                    Properties
                </h2>
                <form class="mt-4 space-y-4" @submit.prevent>
                    @foreach ($playbook->controls as $control)
                        <div>
                            @if ($control->type === 'checkbox')
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-transparent px-1 py-1.5 text-sm text-zinc-800 transition hover:bg-zinc-50 dark:text-zinc-200 dark:hover:bg-zinc-800/60">
                                    <input
                                        type="checkbox"
                                        class="mt-0.5 size-4 shrink-0 rounded border-zinc-300 text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20"
                                        x-model.boolean="state.{{ $control->key }}"
                                        @change="queuePreview()"
                                    >
                                    <span>{{ $control->label }}</span>
                                </label>
                            @elseif ($control->type === 'select')
                                <label class="block text-sm font-medium text-zinc-800 dark:text-zinc-200" for="control-{{ $control->key }}">
                                    {{ $control->label }}
                                </label>
                                <select
                                    id="control-{{ $control->key }}"
                                    class="mt-1.5 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus-visible:border-zinc-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus-visible:border-zinc-600 dark:focus-visible:ring-zinc-300/20"
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
            </div>
        </aside>

        <section class="min-w-0" aria-labelledby="playbook-preview-heading">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 id="playbook-preview-heading" class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                    Live preview
                </h2>
                <p
                    class="text-xs text-zinc-500 transition-opacity dark:text-zinc-400"
                    x-show="loading"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                >
                    Updating preview…
                </p>
            </div>

            <div
                id="playbook-canvas"
                class="playbook-stage mt-4 flex min-h-[min(24rem,50vh)] items-start justify-center overflow-visible rounded-2xl border border-zinc-200/80 bg-white p-8 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-900/50 dark:ring-white/5 sm:p-12"
                aria-live="polite"
                aria-atomic="true"
            >
                <div class="w-full max-w-md" x-html="html"></div>
            </div>

            <div class="mt-8 min-w-0" x-show="snippet.length > 0">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Code
                    </h2>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-xs font-medium text-zinc-700 shadow-sm transition hover:border-zinc-300 hover:bg-zinc-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300/20"
                        @click="copySnippet()"
                    >
                        <span x-text="copied ? 'Copied' : 'Copy'"></span>
                    </button>
                </div>
                <div class="playbook-code mt-3 min-w-0 overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-50 shadow-sm ring-1 ring-zinc-950/5 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-white/5">
                    <pre class="playbook-code__pre max-h-[min(28rem,50vh)] overflow-auto p-4 font-mono text-xs leading-relaxed text-zinc-800 dark:text-zinc-200"><code class="playbook-code__content block whitespace-pre-wrap" x-text="snippet">{{ $initialSnippet }}</code></pre>
                </div>
            </div>
        </section>
    </div>
@endsection
