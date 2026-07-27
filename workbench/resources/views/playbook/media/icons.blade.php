@extends('workbench::playbook.media.layout')

@section('title', 'Icons — BladeX')

@section('content')
    <div class="space-y-10 rounded-3xl border border-zinc-200/80 bg-white p-12 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::icons.* /&gt;</p>
            <x-bladex-components::heading :level="2">Icons (Lucide)</x-bladex-components::heading>
            <x-bladex-components::text size="sm" variant="subtle">Import on demand — outline, mini, and micro sizes.</x-bladex-components::text>
        </div>

        <div class="flex flex-wrap items-end gap-10">
            <div class="space-y-2 text-center">
                <x-bladex-components::icon.loading class="mx-auto size-4" />
                <x-bladex-components::text size="sm" variant="subtle">outline · 16px</x-bladex-components::text>
            </div>
            <div class="space-y-2 text-center">
                <x-bladex-components::icon.loading class="mx-auto size-5" />
                <x-bladex-components::text size="sm" variant="subtle">mini · 20px</x-bladex-components::text>
            </div>
            <div class="space-y-2 text-center">
                <x-bladex-components::icon.loading class="mx-auto size-3" />
                <x-bladex-components::text size="sm" variant="subtle">micro · 12px</x-bladex-components::text>
            </div>
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-bladex-components::text size="sm" variant="subtle" class="mb-4">Inside controls</x-bladex-components::text>
            <div class="flex max-w-xl flex-col gap-4">
                <x-bladex-components::input name="search" placeholder="Search…">
                    <x-slot:leading>
                        <x-bladex-components::icon.loading />
                    </x-slot:leading>
                </x-bladex-components::input>
                <x-bladex-components::button variant="primary">
                    <x-slot:leading>
                        <x-bladex-components::icon.loading class="animate-spin" />
                    </x-slot:leading>
                    Saving…
                </x-bladex-components::button>
            </div>
        </div>
    </div>
@endsection
