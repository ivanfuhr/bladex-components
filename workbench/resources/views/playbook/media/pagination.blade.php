@extends('workbench::playbook.media.layout')

@section('title', 'Pagination — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::pagination /&gt;</p>
            <x-std::heading :level="2">Pagination</x-std::heading>
            <x-std::text size="sm" variant="subtle">Page controls for lists and tables.</x-std::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Manual composition</x-std::text>
                <x-std::pagination>
                    <x-std::pagination.content>
                        <x-std::pagination.item>
                            <x-std::pagination.previous href="#" />
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.link href="#">1</x-std::pagination.link>
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.link href="#" :is-active="true">2</x-std::pagination.link>
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.link href="#">3</x-std::pagination.link>
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.ellipsis />
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.link href="#">12</x-std::pagination.link>
                        </x-std::pagination.item>
                        <x-std::pagination.item>
                            <x-std::pagination.next href="#" />
                        </x-std::pagination.item>
                    </x-std::pagination.content>
                </x-std::pagination>
            </div>
        </div>
    </div>
@endsection
