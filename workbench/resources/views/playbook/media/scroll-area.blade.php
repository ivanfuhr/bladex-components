@extends('workbench::playbook.media.layout')

@section('title', 'Scroll Area — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::scroll-area /&gt;</p>
            <x-std::heading :level="2">Scroll Area</x-std::heading>
            <x-std::text size="sm" variant="subtle">Native scrolling with themed overlay scrollbars.</x-std::text>
        </div>

        <div class="grid max-w-2xl gap-6 sm:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Vertical</x-std::text>
                <x-std::scroll-area
                    class="h-48 rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950"
                    type="always"
                    aria-label="Vertical tags"
                >
                    <div class="space-y-2 p-4">
                        @foreach (['Laravel', 'Livewire', 'Inertia', 'Tailwind', 'Vite', 'Pest', 'PHPStan', 'Flux', 'shadcn'] as $item)
                            <div class="rounded-md border border-zinc-200 px-3 py-2 text-sm text-zinc-800 dark:border-zinc-700 dark:text-zinc-200">
                                {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </x-std::scroll-area>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Both axes</x-std::text>
                <x-std::scroll-area
                    class="h-48 rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950"
                    type="always"
                    horizontal
                    aria-label="Matrix"
                >
                    <div class="w-max p-4">
                        <div class="grid grid-cols-6 gap-2">
                            @foreach (range(1, 24) as $cell)
                                <div class="flex size-16 items-center justify-center rounded-md border border-zinc-200 text-xs text-zinc-600 dark:border-zinc-700 dark:text-zinc-400">
                                    {{ $cell }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-std::scroll-area>
            </div>
        </div>
    </div>
@endsection
