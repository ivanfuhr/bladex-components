@extends('workbench::playbook.media.layout')

@section('title', 'Toggle — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::toggle /&gt;</p>
            <x-stencil::heading :level="2">Toggle</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Two-state pressed button with aria-pressed.</x-stencil::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <x-stencil::toggle aria-label="Toggle italic">Italic</x-stencil::toggle>
            <x-stencil::toggle variant="outline" :pressed="true">Bold</x-stencil::toggle>
            <x-stencil::toggle size="sm" variant="outline">Small</x-stencil::toggle>
            <x-stencil::toggle size="lg" variant="outline">Large</x-stencil::toggle>
        </div>
    </div>
@endsection
