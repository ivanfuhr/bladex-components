@extends('workbench::playbook.media.layout')

@section('title', 'Skeleton — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::skeleton /&gt;</p>
            <x-std::heading :level="2">Skeleton</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Loading placeholders for content that is still arriving.</x-std::text>
        </div>

        <div class="max-w-md space-y-6">
            <div class="flex items-center gap-4">
                <x-std::skeleton rounded="full" class="size-12" />
                <div class="flex-1 space-y-2">
                    <x-std::skeleton class="h-4 w-40" />
                    <x-std::skeleton class="h-3 w-56" />
                </div>
            </div>
            <div class="space-y-2">
                <x-std::skeleton class="h-4 w-full" />
                <x-std::skeleton class="h-4 w-5/6" />
                <x-std::skeleton class="h-4 w-2/3" />
            </div>
            <x-std::skeleton class="h-28 w-full rounded-xl" />
        </div>
    </div>
@endsection
