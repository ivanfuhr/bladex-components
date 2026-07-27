@extends('workbench::playbook.media.layout')

@section('title', 'Field — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::field /&gt;</p>
            <x-stencil::heading :level="2">Field</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Label, control, description, and Laravel validation errors.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-stencil::field name="email" class="max-w-sm">
                <x-stencil::field.label>Email</x-stencil::field.label>
                <x-stencil::input name="email" type="email" placeholder="you@example.com" />
                <x-stencil::field.description>Used for invoices and receipts.</x-stencil::field.description>
            </x-stencil::field>

            <x-stencil::field name="username" :invalid="true" class="max-w-sm">
                <x-stencil::field.label>Username</x-stencil::field.label>
                <x-stencil::input name="username" value="taken" />
                <x-stencil::field.message variant="error">That username is already taken.</x-stencil::field.message>
            </x-stencil::field>
        </div>
    </div>
@endsection
