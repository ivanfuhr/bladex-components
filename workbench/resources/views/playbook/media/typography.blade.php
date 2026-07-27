@extends('workbench::playbook.media.layout')

@section('title', 'Typography — BladeX')

@section('content')
    <div class="space-y-10 rounded-3xl border border-zinc-200/80 bg-white p-12 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::heading /&gt; · &lt;x-ui::text /&gt;</p>
            <x-bladex-components::heading :level="2">Typography</x-bladex-components::heading>
            <x-bladex-components::text size="sm" variant="subtle">Shared size scale, semantic heading levels, and text variants.</x-bladex-components::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-4">
                <x-bladex-components::text size="sm" variant="subtle">Heading levels</x-bladex-components::text>
                <x-bladex-components::heading :level="1">Heading level 1</x-bladex-components::heading>
                <x-bladex-components::heading :level="2">Heading level 2</x-bladex-components::heading>
                <x-bladex-components::heading :level="3">Heading level 3</x-bladex-components::heading>
                <x-bladex-components::heading :level="4" variant="subtle">Subtle heading</x-bladex-components::heading>
            </div>
            <div class="space-y-4">
                <x-bladex-components::text size="sm" variant="subtle">Text sizes &amp; variants</x-bladex-components::text>
                <x-bladex-components::text size="xl">Extra large body</x-bladex-components::text>
                <x-bladex-components::text size="lg">Large body copy</x-bladex-components::text>
                <x-bladex-components::text>Default body copy with a shared scale.</x-bladex-components::text>
                <x-bladex-components::text size="sm" variant="subtle">Small subtle meta text</x-bladex-components::text>
                <x-bladex-components::text variant="strong">Strong emphasis</x-bladex-components::text>
                <x-bladex-components::text variant="error">Error message</x-bladex-components::text>
                <p>
                    <x-bladex-components::text inline color="blue">Blue</x-bladex-components::text>
                    <x-bladex-components::text inline color="emerald"> · Emerald</x-bladex-components::text>
                    <x-bladex-components::text inline color="red"> · Red</x-bladex-components::text>
                </p>
            </div>
        </div>
    </div>
@endsection
