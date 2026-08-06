@extends('workbench::playbook.media.layout')

@section('title', 'Datetime Picker — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::datetime-picker /&gt;</p>
            <x-std::heading :level="2">Datetime Picker</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Combined calendar and time list in one confirmable panel.
            </x-std::text>
        </div>

        <div class="relative mx-auto min-h-[26rem] w-full max-w-lg">
            <x-std::datetime-picker name="media_datetime" value="2026-09-18T09:15" with-today />
        </div>
    </div>
@endsection
