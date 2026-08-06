@extends('workbench::playbook.media.layout')

@section('title', 'Date Picker — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::date-picker /&gt;</p>
            <x-std::heading :level="2">Date Picker</x-std::heading>
            <x-std::text size="sm" variant="subtle"> Date and range selection with a calendar overlay. </x-std::text>
        </div>

        <div class="mx-auto flex w-full max-w-fit flex-col gap-16">
            <div class="relative min-h-[22rem] w-full max-w-sm min-w-[18rem]">
                <x-std::text size="sm" variant="subtle" class="mb-3">Single</x-std::text>
                <x-std::date-picker name="media_date" value="2026-09-18" with-today />
            </div>
            <div class="relative min-h-[22rem] w-full max-w-md min-w-[20rem]">
                <x-std::text size="sm" variant="subtle" class="mb-3">Range</x-std::text>
                <x-std::date-picker name="media_range" mode="range" value="2026-09-14/2026-09-18" with-today />
            </div>
        </div>
    </div>
@endsection
