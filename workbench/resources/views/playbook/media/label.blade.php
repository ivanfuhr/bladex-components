@extends('workbench::playbook.media.layout')

@section('title', 'Label — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::label /&gt;</p>
            <x-ui::heading :level="2">Label</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Associates text with controls; optional badge and required marker.</x-ui::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-ui::label for="email">Email</x-ui::label>
                <x-ui::input name="email" id="email" type="email" placeholder="you@example.com" />
            </div>
            <div class="space-y-3">
                <x-ui::label for="phone" badge="Optional">Phone</x-ui::label>
                <x-ui::input name="phone" id="phone" placeholder="(555) 555-5555" />
            </div>
            <div class="space-y-3">
                <x-ui::label for="password" badge="Required" :required="true">Password</x-ui::label>
                <x-ui::input name="password" id="password" type="password" />
            </div>
        </div>
    </div>
@endsection
