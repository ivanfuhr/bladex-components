@extends('workbench::playbook.media.layout')

@section('title', 'Textarea — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::textarea /&gt;</p>
            <x-stencil::heading :level="2">Textarea</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Multi-line input with invalid and disabled states.</x-stencil::text>
        </div>

        <div class="grid max-w-2xl gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default height (h-9)</x-stencil::text>
                <x-stencil::textarea name="bio" placeholder="About you…" rows="3" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Small (h-8 typography)</x-stencil::text>
                <x-stencil::textarea name="bio-sm" size="sm" placeholder="About you…" rows="3" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Invalid</x-stencil::text>
                <x-stencil::textarea name="bio-invalid" :invalid="true" value="Too short" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Disabled</x-stencil::text>
                <x-stencil::textarea name="bio-disabled" disabled placeholder="Disabled" />
            </div>
        </div>
    </div>
@endsection
