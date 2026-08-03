@extends('workbench::playbook.media.layout')

@section('title', 'Dropdown Menu — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::dropdown-menu /&gt;</p>
            <x-ui::heading :level="2">Dropdown Menu</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Accessible action menu with labels, shortcuts, and danger items.</x-ui::text>
        </div>

        <div class="relative inline-block min-h-[16rem] min-w-[18rem]">
            <x-ui::dropdown-menu align="start">
                <x-ui::dropdown-menu.trigger>
                    <x-ui::button variant="outline">Open menu</x-ui::button>
                </x-ui::dropdown-menu.trigger>
                <x-ui::dropdown-menu.content
                    data-state="open"
                    :hidden="false"
                    class="absolute top-12 left-0 block!"
                    style="position: absolute; top: 3rem; left: 0; display: block"
                >
                    <x-ui::dropdown-menu.label>Account</x-ui::dropdown-menu.label>
                    <x-ui::dropdown-menu.item>Profile</x-ui::dropdown-menu.item>
                    <x-ui::dropdown-menu.item kbd="⌘B">Billing</x-ui::dropdown-menu.item>
                    <x-ui::dropdown-menu.separator />
                    <x-ui::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-ui::dropdown-menu.item>
                </x-ui::dropdown-menu.content>
            </x-ui::dropdown-menu>
        </div>
    </div>
@endsection
