@php
    $align = $state['align'] ?? 'start';
@endphp

<x-std::dropdown-menu :align="$align">
    <x-std::dropdown-menu.trigger>
        <x-std::button variant="outline">Open menu</x-std::button>
    </x-std::dropdown-menu.trigger>
    <x-std::dropdown-menu.content>
        <x-std::dropdown-menu.label>Account</x-std::dropdown-menu.label>
        <x-std::dropdown-menu.item>Profile</x-std::dropdown-menu.item>
        <x-std::dropdown-menu.item>
            Billing
            <x-std::dropdown-menu.shortcut>⌘B</x-std::dropdown-menu.shortcut>
        </x-std::dropdown-menu.item>
        <x-std::dropdown-menu.separator />
        <x-std::dropdown-menu.item variant="danger">
            Delete
            <x-std::dropdown-menu.shortcut>⌘⌫</x-std::dropdown-menu.shortcut>
        </x-std::dropdown-menu.item>
    </x-std::dropdown-menu.content>
</x-std::dropdown-menu>
