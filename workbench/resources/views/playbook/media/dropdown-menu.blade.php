@extends('workbench::playbook.media.layout')

@section('title', 'Dropdown Menu — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::dropdown-menu /&gt;</p>
            <x-std::heading :level="2">Dropdown Menu</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Accessible action menu with labels, shortcuts, and danger items.</x-std::text>
        </div>

        <div class="relative inline-block min-h-[16rem] min-w-[18rem]">
            <x-std::dropdown-menu align="start">
                <x-std::dropdown-menu.trigger>
                    <x-std::button variant="outline">Open menu</x-std::button>
                </x-std::dropdown-menu.trigger>
                <x-std::dropdown-menu.content
                    data-state="open"
                    :hidden="false"
                    class="absolute top-12 left-0 block!"
                    style="position: absolute; top: 3rem; left: 0; display: block"
                >
                    <x-std::dropdown-menu.label>Account</x-std::dropdown-menu.label>
                    <x-std::dropdown-menu.item>Profile</x-std::dropdown-menu.item>
                    <x-std::dropdown-menu.item kbd="⌘B">Billing</x-std::dropdown-menu.item>
                    <x-std::dropdown-menu.separator />
                    <x-std::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-std::dropdown-menu.item>
                </x-std::dropdown-menu.content>
            </x-std::dropdown-menu>
        </div>
    </div>
@endsection
