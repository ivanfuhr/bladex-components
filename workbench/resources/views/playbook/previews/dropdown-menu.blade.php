@php
    $align = $state['align'] ?? 'start';
@endphp

<x-ui::dropdown-menu :align="$align">
    <x-ui::dropdown-menu.trigger>
        <x-ui::button variant="outline">Open menu</x-ui::button>
    </x-ui::dropdown-menu.trigger>
    <x-ui::dropdown-menu.content>
        <x-ui::dropdown-menu.label>Account</x-ui::dropdown-menu.label>
        <x-ui::dropdown-menu.item>Profile</x-ui::dropdown-menu.item>
        <x-ui::dropdown-menu.item>
            Billing
            <x-ui::dropdown-menu.shortcut>⌘B</x-ui::dropdown-menu.shortcut>
        </x-ui::dropdown-menu.item>
        <x-ui::dropdown-menu.separator />
        <x-ui::dropdown-menu.item variant="danger">
            Delete
            <x-ui::dropdown-menu.shortcut>⌘⌫</x-ui::dropdown-menu.shortcut>
        </x-ui::dropdown-menu.item>
    </x-ui::dropdown-menu.content>
</x-ui::dropdown-menu>
