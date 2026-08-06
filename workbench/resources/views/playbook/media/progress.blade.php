@extends('workbench::playbook.media.layout')

@section('title', 'Progress — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::progress /&gt;</p>
            <x-std::heading :level="2">Progress</x-std::heading>
            <x-std::text size="sm" variant="subtle">Determinate and indeterminate progress bars.</x-std::text>
        </div>

        <div class="max-w-md space-y-8">
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">40%</x-std::text>
                <x-std::progress :value="40" />
            </div>
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">75% · large</x-std::text>
                <x-std::progress :value="75" size="lg" />
            </div>
            <div class="space-y-2">
                <x-std::text size="sm" variant="subtle">Indeterminate · small</x-std::text>
                <x-std::progress indeterminate size="sm" />
            </div>
        </div>
    </div>
@endsection
