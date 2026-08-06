@extends('workbench::playbook.media.layout')

@section('title', 'Textarea — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::textarea /&gt;</p>
            <x-std::heading :level="2">Textarea</x-std::heading>
            <x-std::text size="sm" variant="subtle">Multi-line input with invalid and disabled states.</x-std::text>
        </div>

        <div class="grid max-w-2xl gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default height (h-9)</x-std::text>
                <x-std::textarea name="bio" placeholder="About you…" rows="3" />
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Small (h-8 typography)</x-std::text>
                <x-std::textarea name="bio-sm" size="sm" placeholder="About you…" rows="3" />
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Invalid</x-std::text>
                <x-std::textarea name="bio-invalid" :invalid="true" value="Too short" />
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Disabled</x-std::text>
                <x-std::textarea name="bio-disabled" disabled placeholder="Disabled" />
            </div>
        </div>
    </div>
@endsection
