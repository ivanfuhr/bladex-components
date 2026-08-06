@extends('workbench::playbook.media.layout')

@section('title', 'Toggle — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::toggle /&gt;</p>
            <x-std::heading :level="2">Toggle</x-std::heading>
            <x-std::text size="sm" variant="subtle">Two-state pressed button with aria-pressed.</x-std::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <x-std::toggle aria-label="Toggle italic">Italic</x-std::toggle>
            <x-std::toggle variant="outline" :pressed="true">Bold</x-std::toggle>
            <x-std::toggle size="sm" variant="outline">Small</x-std::toggle>
            <x-std::toggle size="lg" variant="outline">Large</x-std::toggle>
        </div>
    </div>
@endsection
