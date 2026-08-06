@extends('workbench::playbook.media.layout')

@section('title', 'Time Picker — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::time-picker /&gt;</p>
            <x-std::heading :level="2">Time Picker</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Scrollable time list with optional seconds and clear.
            </x-std::text>
        </div>

        <div class="relative mx-auto min-h-[22rem] w-full max-w-xs">
            <x-std::time-picker name="media_time" value="09:15" clearable />
        </div>
    </div>
@endsection
