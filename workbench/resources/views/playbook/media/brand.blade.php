@extends('workbench::playbook.media.layout')

@section('title', 'Brand — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::brand /&gt;</p>
            <x-ui::heading :level="2">Brand</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Logo and application name for headers and navbars. Use image URLs, dark-mode logos, or a custom logo
                slot.
            </x-ui::text>
        </div>

        <div class="space-y-6">
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-ui::text size="sm" variant="subtle">Header with custom logo slot</x-ui::text>
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 dark:border-zinc-800 dark:bg-zinc-900/40">
                    <x-ui::header :border="false" class="bg-transparent dark:bg-transparent">
                        <x-ui::brand href="#" name="Stencil Inc.">
                            <x-slot:logo>
                                <span class="text-xs font-bold">S</span>
                            </x-slot:logo>
                        </x-ui::brand>
                    </x-ui::header>
                </div>
            </div>

            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-ui::text size="sm" variant="subtle">Logo only</x-ui::text>
                <x-ui::brand href="#">
                    <x-slot:logo>
                        <span class="text-xs font-bold">S</span>
                    </x-slot:logo>
                </x-ui::brand>
            </div>
        </div>
    </div>
@endsection
