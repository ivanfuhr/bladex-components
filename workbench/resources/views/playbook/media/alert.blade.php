@extends('workbench::playbook.media.layout')

@section('title', 'Alert — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::alert /&gt;</p>
            <x-ui::heading :level="2">Alert</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Inline callouts for info, success, warning, and danger.</x-ui::text>
        </div>

        <div class="mx-auto flex w-full max-w-xl flex-col gap-3">
            <x-ui::alert title="Note">
                <x-ui::alert.description>This is a neutral status message.</x-ui::alert.description>
            </x-ui::alert>
            <x-ui::alert variant="info" title="Tip" icon="clipboard">
                <x-ui::alert.description>You can copy this invite link anytime.</x-ui::alert.description>
            </x-ui::alert>
            <x-ui::alert variant="success" title="Payment received" icon="check">
                <x-ui::alert.description>Invoice INV-204 was marked as paid.</x-ui::alert.description>
            </x-ui::alert>
            <x-ui::alert variant="warning" title="Heads up">
                <x-ui::alert.description>Check your billing details before renewing.</x-ui::alert.description>
            </x-ui::alert>
            <x-ui::alert variant="danger" title="Action required">
                <x-ui::alert.description> Your API key was revoked. Generate a new one.</x-ui::alert.description>
            </x-ui::alert>
        </div>
    </div>
@endsection
