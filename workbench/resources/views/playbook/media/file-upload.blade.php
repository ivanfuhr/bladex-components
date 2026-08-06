@extends('workbench::playbook.media.layout')

@section('title', 'File Upload — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::file-upload /&gt;</p>
            <x-std::heading :level="2">File Upload</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Native multipart file input with drag-and-drop, file list, and remove — no Livewire
                required.</x-std::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default</x-std::text>
                <x-std::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" class="w-full" />
            </div>
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Multiple · invalid · disabled</x-std::text>
                <x-std::file-upload
                    name="attachments"
                    multiple
                    accept=".pdf,.doc,.docx"
                    text="Documents"
                    class="w-full"
                />
                <x-std::file-upload name="bad" invalid text="Invalid upload" class="w-full" />
                <x-std::file-upload name="off" disabled text="Disabled upload" class="w-full" />
            </div>
        </div>
    </div>
@endsection
