@extends('workbench::playbook.media.layout')

@section('title', 'Icons — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::icon.* /&gt;</p>
            <x-ui::heading :level="2">Icons (Lucide)</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Playbook gallery for the registry <code class="font-mono text-xs">icon</code> item — import on demand
                with outline, mini, and micro sizes.
            </x-ui::text>
        </div>

        <div class="flex flex-wrap items-end gap-10">
            <div class="space-y-2 text-center">
                <x-ui::icon.loading class="mx-auto size-4" />
                <x-ui::text size="sm" variant="subtle">outline · 16px</x-ui::text>
            </div>
            <div class="space-y-2 text-center">
                <x-ui::icon.loading class="mx-auto size-5" />
                <x-ui::text size="sm" variant="subtle">mini · 20px</x-ui::text>
            </div>
            <div class="space-y-2 text-center">
                <x-ui::icon.loading class="mx-auto size-3" />
                <x-ui::text size="sm" variant="subtle">micro · 12px</x-ui::text>
            </div>
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-ui::text size="sm" variant="subtle" class="mb-4">Inside controls</x-ui::text>
            <div class="flex max-w-xl flex-col gap-4">
                <x-ui::input name="search" placeholder="Search…">
                    <x-slot:leading>
                        <x-ui::icon.loading />
                    </x-slot:leading>
                </x-ui::input>
                <x-ui::button variant="primary">
                    <x-slot:leading>
                        <x-ui::icon.loading class="animate-spin" />
                    </x-slot:leading>
                    Saving…
                </x-ui::button>
            </div>
        </div>
    </div>
@endsection
