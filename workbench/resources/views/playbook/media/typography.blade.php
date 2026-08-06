@extends('workbench::playbook.media.layout')

@section('title', 'Typography — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                &lt;x-std::heading /&gt; · &lt;x-std::text /&gt;
            </p>
            <x-std::heading :level="2">Typography</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Aggregate media for the <code class="font-mono text-xs">heading</code> and
                <code class="font-mono text-xs">text</code> playbook components — shared size scale, semantic heading
                levels, and text variants.
            </x-std::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-4">
                <x-std::text size="sm" variant="subtle">Heading levels</x-std::text>
                <x-std::heading :level="1">Heading level 1</x-std::heading>
                <x-std::heading :level="2">Heading level 2</x-std::heading>
                <x-std::heading :level="3">Heading level 3</x-std::heading>
                <x-std::heading :level="4" variant="subtle">Subtle heading</x-std::heading>
            </div>
            <div class="space-y-4">
                <x-std::text size="sm" variant="subtle">Text sizes &amp; variants</x-std::text>
                <x-std::text size="xl">Extra large body</x-std::text>
                <x-std::text size="lg">Large body copy</x-std::text>
                <x-std::text>Default body copy with a shared scale.</x-std::text>
                <x-std::text size="sm" variant="subtle">Small subtle meta text</x-std::text>
                <x-std::text variant="strong">Strong emphasis</x-std::text>
                <x-std::text variant="error">Error message</x-std::text>
                <p>
                    <x-std::text inline color="blue">Blue</x-std::text>
                    <x-std::text inline color="emerald"> · Emerald</x-std::text>
                    <x-std::text inline color="red"> · Red</x-std::text>
                </p>
            </div>
        </div>
    </div>
@endsection
