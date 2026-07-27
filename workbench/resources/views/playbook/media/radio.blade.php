@extends('workbench::playbook.media.layout')

@section('title', 'Radio — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::radio.group /&gt;</p>
            <x-stencil::heading :level="2">Radio</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Single choice within a named group.</x-stencil::text>
        </div>

        <x-stencil::radio.group name="plan" legend="Plan" class="max-w-md">
            <x-stencil::radio value="free">Free</x-stencil::radio>
            <x-stencil::radio value="pro" :checked="true">Pro</x-stencil::radio>
            <x-stencil::radio value="team">Team</x-stencil::radio>
        </x-stencil::radio.group>
    </div>
@endsection
