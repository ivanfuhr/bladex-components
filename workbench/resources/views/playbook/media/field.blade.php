@extends('workbench::playbook.media.layout')

@section('title', 'Field — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::field /&gt;</p>
            <x-ui::heading :level="2">Field</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Label, control, description, and Laravel validation errors.</x-ui::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-ui::field name="email" class="max-w-sm">
                <x-ui::field.label>Email</x-ui::field.label>
                <x-ui::input name="email" type="email" placeholder="you@example.com" />
                <x-ui::field.description>Used for invoices and receipts.</x-ui::field.description>
            </x-ui::field>

            <x-ui::field name="username" :invalid="true" class="max-w-sm">
                <x-ui::field.label>Username</x-ui::field.label>
                <x-ui::input name="username" value="taken" />
                <x-ui::field.message variant="error">That username is already taken.</x-ui::field.message>
            </x-ui::field>
        </div>
    </div>
@endsection
