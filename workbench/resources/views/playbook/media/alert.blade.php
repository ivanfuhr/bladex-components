@extends('workbench::playbook.media.layout')

@section('title', 'Alert — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::alert /&gt;</p>
            <x-stencil::heading :level="2">Alert</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Inline callouts for info, success, warning, and danger.</x-stencil::text>
        </div>

        <div class="mx-auto flex w-full max-w-xl flex-col gap-3">
            <x-stencil::alert title="Note">
                <x-stencil::alert.description>This is a neutral status message.</x-stencil::alert.description>
            </x-stencil::alert>
            <x-stencil::alert variant="info" title="Tip" icon="clipboard">
                <x-stencil::alert.description>You can copy this invite link anytime.</x-stencil::alert.description>
            </x-stencil::alert>
            <x-stencil::alert variant="success" title="Payment received" icon="check">
                <x-stencil::alert.description>Invoice INV-204 was marked as paid.</x-stencil::alert.description>
            </x-stencil::alert>
            <x-stencil::alert variant="warning" title="Heads up">
                <x-stencil::alert.description>Check your billing details before renewing.</x-stencil::alert.description>
            </x-stencil::alert>
            <x-stencil::alert variant="danger" title="Action required">
                <x-stencil::alert.description>
                    Your API key was revoked. Generate a new one.</x-stencil::alert.description>
            </x-stencil::alert>
        </div>
    </div>
@endsection
