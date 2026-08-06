@extends('workbench::playbook.media.layout')

@section('title', 'Label — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::label /&gt;</p>
            <x-std::heading :level="2">Label</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Associates text with controls; optional badge and required marker.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::label for="email">Email</x-std::label>
                <x-std::input name="email" id="email" type="email" placeholder="you@example.com" />
            </div>
            <div class="space-y-3">
                <x-std::label for="phone" badge="Optional">Phone</x-std::label>
                <x-std::input name="phone" id="phone" placeholder="(555) 555-5555" />
            </div>
            <div class="space-y-3">
                <x-std::label for="password" badge="Required" :required="true">Password</x-std::label>
                <x-std::input name="password" id="password" type="password" />
            </div>
        </div>
    </div>
@endsection
