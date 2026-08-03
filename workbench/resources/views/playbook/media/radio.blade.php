@extends('workbench::playbook.media.layout')

@section('title', 'Radio — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::radio.group /&gt;</p>
            <x-ui::heading :level="2">Radio</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Single choice within a named group.</x-ui::text>
        </div>

        <x-ui::radio.group name="plan" legend="Plan" class="max-w-md">
            <x-ui::radio value="free">Free</x-ui::radio>
            <x-ui::radio value="pro" :checked="true">Pro</x-ui::radio>
            <x-ui::radio value="team">Team</x-ui::radio>
        </x-ui::radio.group>
    </div>
@endsection
