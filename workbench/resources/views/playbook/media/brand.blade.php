@extends('workbench::playbook.media.layout')

@section('title', 'Brand — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::brand /&gt;</p>
            <x-std::heading :level="2">Brand</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Logo and application name for headers and navbars. Use image URLs, dark-mode logos, or a custom logo
                slot.
            </x-std::text>
        </div>

        <div class="space-y-6">
            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-std::text size="sm" variant="subtle">Header with custom logo slot</x-std::text>
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 dark:border-zinc-800 dark:bg-zinc-900/40">
                    <x-std::header :border="false" class="bg-transparent dark:bg-transparent">
                        <x-std::brand href="#" name="Std Components Inc.">
                            <x-slot:logo>
                                <span class="text-xs font-bold">S</span>
                            </x-slot:logo>
                        </x-std::brand>
                    </x-std::header>
                </div>
            </div>

            <div class="space-y-3 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
                <x-std::text size="sm" variant="subtle">Logo only</x-std::text>
                <x-std::brand href="#">
                    <x-slot:logo>
                        <span class="text-xs font-bold">S</span>
                    </x-slot:logo>
                </x-std::brand>
            </div>
        </div>
    </div>
@endsection
