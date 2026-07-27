@extends('workbench::playbook.media.layout')

@section('title', 'Typography — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::heading /&gt; · &lt;x-ui::text /&gt;</p>
            <x-stencil::heading :level="2">Typography</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Shared size scale, semantic heading levels, and text variants.</x-stencil::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-4">
                <x-stencil::text size="sm" variant="subtle">Heading levels</x-stencil::text>
                <x-stencil::heading :level="1">Heading level 1</x-stencil::heading>
                <x-stencil::heading :level="2">Heading level 2</x-stencil::heading>
                <x-stencil::heading :level="3">Heading level 3</x-stencil::heading>
                <x-stencil::heading :level="4" variant="subtle">Subtle heading</x-stencil::heading>
            </div>
            <div class="space-y-4">
                <x-stencil::text size="sm" variant="subtle">Text sizes &amp; variants</x-stencil::text>
                <x-stencil::text size="xl">Extra large body</x-stencil::text>
                <x-stencil::text size="lg">Large body copy</x-stencil::text>
                <x-stencil::text>Default body copy with a shared scale.</x-stencil::text>
                <x-stencil::text size="sm" variant="subtle">Small subtle meta text</x-stencil::text>
                <x-stencil::text variant="strong">Strong emphasis</x-stencil::text>
                <x-stencil::text variant="error">Error message</x-stencil::text>
                <p>
                    <x-stencil::text inline color="blue">Blue</x-stencil::text>
                    <x-stencil::text inline color="emerald"> · Emerald</x-stencil::text>
                    <x-stencil::text inline color="red"> · Red</x-stencil::text>
                </p>
            </div>
        </div>
    </div>
@endsection
