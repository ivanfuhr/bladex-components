@extends('workbench::playbook.media.layout')

@section('title', 'Field — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::field /&gt;</p>
            <x-std::heading :level="2">Field</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Label, control, description, and Laravel validation errors.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-std::field name="email" class="max-w-sm">
                <x-std::field.label>Email</x-std::field.label>
                <x-std::input name="email" type="email" placeholder="you@example.com" />
                <x-std::field.description>Used for invoices and receipts.</x-std::field.description>
            </x-std::field>

            <x-std::field name="username" :invalid="true" class="max-w-sm">
                <x-std::field.label>Username</x-std::field.label>
                <x-std::input name="username" value="taken" />
                <x-std::field.message variant="error">That username is already taken.</x-std::field.message>
            </x-std::field>
        </div>
    </div>
@endsection
