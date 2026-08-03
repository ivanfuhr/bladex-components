@extends('workbench::playbook.media.layout')

@section('title', 'Pillbox — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::pillbox /&gt;</p>
            <x-ui::heading :level="2">Pillbox</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Free-text tags input with native name[] submission.</x-ui::text>
        </div>

        <x-ui::pillbox name="tags" :value="['laravel', 'php']" placeholder="Add tags…" class="w-full max-w-xl" />
    </div>
@endsection
