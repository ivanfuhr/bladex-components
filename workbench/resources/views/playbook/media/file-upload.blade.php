@extends('workbench::playbook.media.layout')

@section('title', 'File Upload — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::file-upload /&gt;</p>
            <x-stencil::heading :level="2">File Upload</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Native multipart file input with drag-and-drop, file list, and remove — no Livewire
                required.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" class="w-full" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Multiple · invalid · disabled</x-stencil::text>
                <x-stencil::file-upload
                    name="attachments"
                    multiple
                    accept=".pdf,.doc,.docx"
                    text="Documents"
                    class="w-full"
                />
                <x-stencil::file-upload name="bad" invalid text="Invalid upload" class="w-full" />
                <x-stencil::file-upload name="off" disabled text="Disabled upload" class="w-full" />
            </div>
        </div>
    </div>
@endsection
