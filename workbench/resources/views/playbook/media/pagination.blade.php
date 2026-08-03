@extends('workbench::playbook.media.layout')

@section('title', 'Pagination — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::pagination /&gt;</p>
            <x-ui::heading :level="2">Pagination</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Page controls for lists and tables.</x-ui::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Manual composition</x-ui::text>
                <x-ui::pagination>
                    <x-ui::pagination.content>
                        <x-ui::pagination.item>
                            <x-ui::pagination.previous href="#" />
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.link href="#">1</x-ui::pagination.link>
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.link href="#" :is-active="true">2</x-ui::pagination.link>
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.link href="#">3</x-ui::pagination.link>
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.ellipsis />
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.link href="#">12</x-ui::pagination.link>
                        </x-ui::pagination.item>
                        <x-ui::pagination.item>
                            <x-ui::pagination.next href="#" />
                        </x-ui::pagination.item>
                    </x-ui::pagination.content>
                </x-ui::pagination>
            </div>
        </div>
    </div>
@endsection
