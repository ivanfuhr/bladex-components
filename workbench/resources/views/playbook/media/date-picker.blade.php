@extends('workbench::playbook.media.layout')

@section('title', 'Date Picker — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::date-picker /&gt;</p>
            <x-stencil::heading :level="2">Date Picker</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Date and range selection with a calendar overlay.
            </x-stencil::text>
        </div>

        <div class="mx-auto flex w-full max-w-sm flex-col gap-4">
            <x-stencil::date-picker name="media_date" value="2026-09-18" with-today />
            <x-stencil::date-picker name="media_range" mode="range" value="2026-09-14/2026-09-18" with-today />
        </div>
    </div>
@endsection
