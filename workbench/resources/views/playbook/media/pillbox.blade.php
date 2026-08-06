@extends('workbench::playbook.media.layout')

@section('title', 'Pillbox — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::pillbox /&gt;</p>
            <x-std::heading :level="2">Pillbox</x-std::heading>
            <x-std::text size="sm" variant="subtle">Free-text tags input with native name[] submission.</x-std::text>
        </div>

        <x-std::pillbox name="tags" :value="['laravel', 'php']" placeholder="Add tags…" class="w-full max-w-xl" />
    </div>
@endsection
