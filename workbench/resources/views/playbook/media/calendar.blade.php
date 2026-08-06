@extends('workbench::playbook.media.layout')

@section('title', 'Calendar — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::calendar /&gt;</p>
            <x-std::heading :level="2">Calendar</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Standalone month grid for single-day or range selection.
            </x-std::text>
        </div>

        <div class="flex flex-wrap items-start justify-center gap-10">
            <x-std::calendar value="2026-09-18" with-today class="w-fit" />
            <x-std::calendar mode="range" value="2026-09-14/2026-09-18" with-today class="w-fit" />
        </div>
    </div>
@endsection
