@extends('workbench::playbook.media.layout')

@section('title', 'Time Picker — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::time-picker /&gt;</p>
            <x-stencil::heading :level="2">Time Picker</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Scrollable time list with optional seconds and clear.
            </x-stencil::text>
        </div>

        <div class="relative mx-auto min-h-[22rem] w-full max-w-xs">
            <x-stencil::time-picker name="media_time" value="09:15" clearable />
        </div>
    </div>
@endsection
