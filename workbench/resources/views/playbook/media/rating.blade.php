@extends('workbench::playbook.media.layout')

@section('title', 'Rating — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::rating /&gt;</p>
            <x-std::heading :level="2">Rating</x-std::heading>
            <x-std::text size="sm" variant="subtle">Accessible star rating that submits a numeric score.</x-std::text>
        </div>

        <x-std::rating name="score" :value="4" :max="5" />
    </div>
@endsection
