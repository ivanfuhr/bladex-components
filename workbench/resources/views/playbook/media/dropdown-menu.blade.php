@extends('workbench::playbook.media.layout')

@section('title', 'Dropdown Menu — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::dropdown-menu /&gt;</p>
            <x-stencil::heading :level="2">Dropdown Menu</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Accessible action menu with labels, shortcuts, and danger items.</x-stencil::text>
        </div>

        <div class="relative inline-block min-h-[16rem] min-w-[18rem]">
            <x-stencil::dropdown-menu align="start">
                <x-stencil::dropdown-menu.trigger>
                    <x-stencil::button variant="outline">Open menu</x-stencil::button>
                </x-stencil::dropdown-menu.trigger>
                <x-stencil::dropdown-menu.content
                    data-state="open"
                    :hidden="false"
                    class="absolute top-12 left-0 block!"
                    style="position: absolute; top: 3rem; left: 0; display: block;"
                >
                    <x-stencil::dropdown-menu.label>Account</x-stencil::dropdown-menu.label>
                    <x-stencil::dropdown-menu.item>Profile</x-stencil::dropdown-menu.item>
                    <x-stencil::dropdown-menu.item kbd="⌘B">Billing</x-stencil::dropdown-menu.item>
                    <x-stencil::dropdown-menu.separator />
                    <x-stencil::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-stencil::dropdown-menu.item>
                </x-stencil::dropdown-menu.content>
            </x-stencil::dropdown-menu>
        </div>
    </div>
@endsection
