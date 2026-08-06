@extends('workbench::playbook.media.layout')

@section('title', 'Alert — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::alert /&gt;</p>
            <x-std::heading :level="2">Alert</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Inline callouts for info, success, warning, and danger.</x-std::text>
        </div>

        <div class="mx-auto flex w-full max-w-xl flex-col gap-3">
            <x-std::alert title="Note">
                <x-std::alert.description>This is a neutral status message.</x-std::alert.description>
            </x-std::alert>
            <x-std::alert variant="info" title="Tip" icon="clipboard">
                <x-std::alert.description>You can copy this invite link anytime.</x-std::alert.description>
            </x-std::alert>
            <x-std::alert variant="success" title="Payment received" icon="check">
                <x-std::alert.description>Invoice INV-204 was marked as paid.</x-std::alert.description>
            </x-std::alert>
            <x-std::alert variant="warning" title="Heads up">
                <x-std::alert.description>Check your billing details before renewing.</x-std::alert.description>
            </x-std::alert>
            <x-std::alert variant="danger" title="Action required">
                <x-std::alert.description> Your API key was revoked. Generate a new one.</x-std::alert.description>
            </x-std::alert>
        </div>
    </div>
@endsection
