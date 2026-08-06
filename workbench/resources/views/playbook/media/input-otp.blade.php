@extends('workbench::playbook.media.layout')

@section('title', 'Input OTP — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::input-otp /&gt;</p>
            <x-std::heading :level="2">Input OTP</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >One-time password / PIN slots with paste, arrow keys, and a combined hidden form value.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default (6 · numeric)</x-std::text>
                <x-std::input-otp name="code" />
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">PIN · alphanumeric · invalid · disabled</x-std::text>
                <x-std::input-otp name="pin" :length="4" />
                <x-std::input-otp name="token" mode="alphanumeric" :length="6" :separated="false" />
                <x-std::input-otp name="bad" invalid />
                <x-std::input-otp name="off" disabled />
            </div>
        </div>
    </div>
@endsection
