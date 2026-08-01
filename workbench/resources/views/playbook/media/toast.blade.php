@extends('workbench::playbook.media.layout')

@section('title', 'Toast — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::toast /&gt;</p>
            <x-stencil::heading :level="2">Toast</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Transient notifications with success, warning, and danger variants.</x-stencil::text>
        </div>

        <div class="mx-auto flex w-full max-w-sm flex-col gap-3">
            <x-stencil::toast title="Saved" description="Your changes were saved." :duration="999999" />
            <x-stencil::toast
                variant="success"
                title="Invite sent"
                description="Taylor can now join the workspace."
                :duration="999999"
            />
            <x-stencil::toast
                variant="warning"
                title="Heads up"
                description="Your trial ends in 3 days."
                :duration="999999"
            />
            <x-stencil::toast
                variant="danger"
                title="Upload failed"
                description="The file was too large. Try again."
                :duration="999999"
            />
        </div>
    </div>
@endsection
