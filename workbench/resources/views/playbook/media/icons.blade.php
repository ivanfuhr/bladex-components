@extends('workbench::playbook.media.layout')

@section('title', 'Icons — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::icon.* /&gt;</p>
            <x-std::heading :level="2">Icons (Lucide)</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Playbook gallery for the registry <code class="font-mono text-xs">icon</code> item — import on demand
                with outline, mini, and micro sizes.
            </x-std::text>
        </div>

        <div class="flex flex-wrap items-end gap-10">
            <div class="space-y-2 text-center">
                <x-std::icon.loading class="mx-auto size-4" />
                <x-std::text size="sm" variant="subtle">outline · 16px</x-std::text>
            </div>
            <div class="space-y-2 text-center">
                <x-std::icon.loading class="mx-auto size-5" />
                <x-std::text size="sm" variant="subtle">mini · 20px</x-std::text>
            </div>
            <div class="space-y-2 text-center">
                <x-std::icon.loading class="mx-auto size-3" />
                <x-std::text size="sm" variant="subtle">micro · 12px</x-std::text>
            </div>
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-std::text size="sm" variant="subtle" class="mb-4">Inside controls</x-std::text>
            <div class="flex max-w-xl flex-col gap-4">
                <x-std::input name="search" placeholder="Search…">
                    <x-slot:leading>
                        <x-std::icon.loading />
                    </x-slot:leading>
                </x-std::input>
                <x-std::button variant="primary">
                    <x-slot:leading>
                        <x-std::icon.loading class="animate-spin" />
                    </x-slot:leading>
                    Saving…
                </x-std::button>
            </div>
        </div>
    </div>
@endsection
