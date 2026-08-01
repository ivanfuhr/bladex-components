@php
    $align = $state['align'] ?? 'start';
@endphp

<x-stencil::dropdown-menu :align="$align">
    <x-stencil::dropdown-menu.trigger>
        <x-stencil::button variant="outline">Open menu</x-stencil::button>
    </x-stencil::dropdown-menu.trigger>
    <x-stencil::dropdown-menu.content>
        <x-stencil::dropdown-menu.label>Account</x-stencil::dropdown-menu.label>
        <x-stencil::dropdown-menu.item>Profile</x-stencil::dropdown-menu.item>
        <x-stencil::dropdown-menu.item>
            Billing
            <x-stencil::dropdown-menu.shortcut>⌘B</x-stencil::dropdown-menu.shortcut>
        </x-stencil::dropdown-menu.item>
        <x-stencil::dropdown-menu.separator />
        <x-stencil::dropdown-menu.item variant="danger">
            Delete
            <x-stencil::dropdown-menu.shortcut>⌘⌫</x-stencil::dropdown-menu.shortcut>
        </x-stencil::dropdown-menu.item>
    </x-stencil::dropdown-menu.content>
</x-stencil::dropdown-menu>
