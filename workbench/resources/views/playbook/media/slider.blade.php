@extends('workbench::playbook.media.layout')

@section('title', 'Slider — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::slider /&gt;</p>
            <x-stencil::heading :level="2">Slider</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Accessible single or dual-thumb range slider with keyboard support and a hidden form
                value.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::slider name="volume" :value="40" class="w-full" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Range · small · invalid · disabled</x-stencil::text>
                <x-stencil::slider name="price" :value="[20, 80]" class="w-full" />
                <x-stencil::slider name="compact" :value="50" size="sm" class="w-full" />
                <x-stencil::slider name="bad" :value="30" invalid class="w-full" />
                <x-stencil::slider name="off" :value="60" disabled class="w-full" />
            </div>
        </div>
    </div>
@endsection
