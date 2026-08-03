@extends('workbench::playbook.media.layout')

@section('title', 'Toggle — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::toggle /&gt;</p>
            <x-ui::heading :level="2">Toggle</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Two-state pressed button with aria-pressed.</x-ui::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <x-ui::toggle aria-label="Toggle italic">Italic</x-ui::toggle>
            <x-ui::toggle variant="outline" :pressed="true">Bold</x-ui::toggle>
            <x-ui::toggle size="sm" variant="outline">Small</x-ui::toggle>
            <x-ui::toggle size="lg" variant="outline">Large</x-ui::toggle>
        </div>
    </div>
@endsection
