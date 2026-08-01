@extends('workbench::playbook.media.layout')

@section('title', 'Pagination — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::pagination /&gt;</p>
            <x-stencil::heading :level="2">Pagination</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Page controls for lists and tables.</x-stencil::text>
        </div>

        <div class="space-y-8">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Manual composition</x-stencil::text>
                <x-stencil::pagination>
                    <x-stencil::pagination.content>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.previous href="#" />
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.link href="#">1</x-stencil::pagination.link>
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.link href="#" :is-active="true">2</x-stencil::pagination.link>
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.link href="#">3</x-stencil::pagination.link>
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.ellipsis />
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.link href="#">12</x-stencil::pagination.link>
                        </x-stencil::pagination.item>
                        <x-stencil::pagination.item>
                            <x-stencil::pagination.next href="#" />
                        </x-stencil::pagination.item>
                    </x-stencil::pagination.content>
                </x-stencil::pagination>
            </div>
        </div>
    </div>
@endsection
