@extends('workbench::playbook.media.layout')

@section('title', 'Input OTP — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::input-otp /&gt;</p>
            <x-stencil::heading :level="2">Input OTP</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >One-time password / PIN slots with paste, arrow keys, and a combined hidden form
                value.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default (6 · numeric)</x-stencil::text>
                <x-stencil::input-otp name="code" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">PIN · alphanumeric · invalid · disabled</x-stencil::text>
                <x-stencil::input-otp name="pin" :length="4" />
                <x-stencil::input-otp name="token" mode="alphanumeric" :length="6" :separated="false" />
                <x-stencil::input-otp name="bad" invalid />
                <x-stencil::input-otp name="off" disabled />
            </div>
        </div>
    </div>
@endsection
