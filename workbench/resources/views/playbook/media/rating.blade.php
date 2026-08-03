@extends('workbench::playbook.media.layout')

@section('title', 'Rating — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::rating /&gt;</p>
            <x-ui::heading :level="2">Rating</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Accessible star rating that submits a numeric score.</x-ui::text>
        </div>

        <x-ui::rating name="score" :value="4" :max="5" />
    </div>
@endsection
