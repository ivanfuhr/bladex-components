@extends('workbench::playbook.media.layout')

@section('title', 'Icons — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::icons.* /&gt;</p>
            <x-stencil::heading :level="2">Icons (Lucide)</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Import on demand — outline, mini, and micro sizes.</x-stencil::text>
        </div>

        <div class="flex flex-wrap items-end gap-10">
            <div class="space-y-2 text-center">
                <x-stencil::icon.loading class="mx-auto size-4" />
                <x-stencil::text size="sm" variant="subtle">outline · 16px</x-stencil::text>
            </div>
            <div class="space-y-2 text-center">
                <x-stencil::icon.loading class="mx-auto size-5" />
                <x-stencil::text size="sm" variant="subtle">mini · 20px</x-stencil::text>
            </div>
            <div class="space-y-2 text-center">
                <x-stencil::icon.loading class="mx-auto size-3" />
                <x-stencil::text size="sm" variant="subtle">micro · 12px</x-stencil::text>
            </div>
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-stencil::text size="sm" variant="subtle" class="mb-4">Inside controls</x-stencil::text>
            <div class="flex max-w-xl flex-col gap-4">
                <x-stencil::input name="search" placeholder="Search…">
                    <x-slot:leading>
                        <x-stencil::icon.loading />
                    </x-slot:leading>
                </x-stencil::input>
                <x-stencil::button variant="primary">
                    <x-slot:leading>
                        <x-stencil::icon.loading class="animate-spin" />
                    </x-slot:leading>
                    Saving…
                </x-stencil::button>
            </div>
        </div>
    </div>
@endsection
