@extends('workbench::playbook.media.layout')

@section('title', 'Typography — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                &lt;x-ui::heading /&gt; · &lt;x-ui::text /&gt;
            </p>
            <x-ui::heading :level="2">Typography</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Aggregate media for the <code class="font-mono text-xs">heading</code> and
                <code class="font-mono text-xs">text</code> playbook components — shared size scale, semantic heading
                levels, and text variants.
            </x-ui::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-4">
                <x-ui::text size="sm" variant="subtle">Heading levels</x-ui::text>
                <x-ui::heading :level="1">Heading level 1</x-ui::heading>
                <x-ui::heading :level="2">Heading level 2</x-ui::heading>
                <x-ui::heading :level="3">Heading level 3</x-ui::heading>
                <x-ui::heading :level="4" variant="subtle">Subtle heading</x-ui::heading>
            </div>
            <div class="space-y-4">
                <x-ui::text size="sm" variant="subtle">Text sizes &amp; variants</x-ui::text>
                <x-ui::text size="xl">Extra large body</x-ui::text>
                <x-ui::text size="lg">Large body copy</x-ui::text>
                <x-ui::text>Default body copy with a shared scale.</x-ui::text>
                <x-ui::text size="sm" variant="subtle">Small subtle meta text</x-ui::text>
                <x-ui::text variant="strong">Strong emphasis</x-ui::text>
                <x-ui::text variant="error">Error message</x-ui::text>
                <p>
                    <x-ui::text inline color="blue">Blue</x-ui::text>
                    <x-ui::text inline color="emerald"> · Emerald</x-ui::text>
                    <x-ui::text inline color="red"> · Red</x-ui::text>
                </p>
            </div>
        </div>
    </div>
@endsection
