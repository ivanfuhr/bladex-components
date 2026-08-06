@extends('workbench::playbook.media.layout')

@section('title', 'Radio — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::radio.group /&gt;</p>
            <x-std::heading :level="2">Radio</x-std::heading>
            <x-std::text size="sm" variant="subtle">Single choice within a named group.</x-std::text>
        </div>

        <x-std::radio.group name="plan" legend="Plan" class="max-w-md">
            <x-std::radio value="free">Free</x-std::radio>
            <x-std::radio value="pro" :checked="true">Pro</x-std::radio>
            <x-std::radio value="team">Team</x-std::radio>
        </x-std::radio.group>
    </div>
@endsection
