@extends('workbench::playbook.media.layout')

@section('title', 'Progress — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::progress /&gt;</p>
            <x-ui::heading :level="2">Progress</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Determinate and indeterminate progress bars.</x-ui::text>
        </div>

        <div class="max-w-md space-y-8">
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">40%</x-ui::text>
                <x-ui::progress :value="40" />
            </div>
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">75% · large</x-ui::text>
                <x-ui::progress :value="75" size="lg" />
            </div>
            <div class="space-y-2">
                <x-ui::text size="sm" variant="subtle">Indeterminate · small</x-ui::text>
                <x-ui::progress indeterminate size="sm" />
            </div>
        </div>
    </div>
@endsection
