@extends('workbench::playbook.media.layout')

@section('title', 'Datetime Picker — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::datetime-picker /&gt;</p>
            <x-stencil::heading :level="2">Datetime Picker</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">
                Combined calendar and time list in one confirmable panel.
            </x-stencil::text>
        </div>

        <div class="mx-auto w-full max-w-sm">
            <x-stencil::datetime-picker name="media_datetime" value="2026-09-18T09:15" with-today />
        </div>
    </div>
@endsection
