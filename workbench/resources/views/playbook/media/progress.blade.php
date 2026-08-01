@extends('workbench::playbook.media.layout')

@section('title', 'Progress — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::progress /&gt;</p>
            <x-stencil::heading :level="2">Progress</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Determinate and indeterminate progress bars.</x-stencil::text>
        </div>

        <div class="max-w-md space-y-8">
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">40%</x-stencil::text>
                <x-stencil::progress :value="40" />
            </div>
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">75% · large</x-stencil::text>
                <x-stencil::progress :value="75" size="lg" />
            </div>
            <div class="space-y-2">
                <x-stencil::text size="sm" variant="subtle">Indeterminate · small</x-stencil::text>
                <x-stencil::progress indeterminate size="sm" />
            </div>
        </div>
    </div>
@endsection
