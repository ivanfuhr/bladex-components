<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dropdown menu with trigger content and items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dropdown-menu align="end">
            <x-stencil::dropdown-menu.trigger>
                <x-stencil::button variant="outline">Open</x-stencil::button>
            </x-stencil::dropdown-menu.trigger>
            <x-stencil::dropdown-menu.content>
                <x-stencil::dropdown-menu.label>Account</x-stencil::dropdown-menu.label>
                <x-stencil::dropdown-menu.item>Profile</x-stencil::dropdown-menu.item>
                <x-stencil::dropdown-menu.separator />
                <x-stencil::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-stencil::dropdown-menu.item>
            </x-stencil::dropdown-menu.content>
        </x-stencil::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('data-dropdown-menu')
        ->toContain('data-align="end"')
        ->toContain('data-dropdown-menu-trigger')
        ->toContain('data-dropdown-menu-content')
        ->toContain('role="menu"')
        ->toContain('role="menuitem"')
        ->toContain('Account')
        ->toContain('Profile')
        ->toContain('data-dropdown-menu-separator')
        ->toContain('data-variant="danger"')
        ->toContain('⌘⌫')
        ->toContain('Delete');
});

it('supports grouped items and disabled state', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dropdown-menu>
            <x-stencil::dropdown-menu.trigger>
                <button type="button">Menu</button>
            </x-stencil::dropdown-menu.trigger>
            <x-stencil::dropdown-menu.content>
                <x-stencil::dropdown-menu.group heading="Billing">
                    <x-stencil::dropdown-menu.item href="/invoices">Invoices</x-stencil::dropdown-menu.item>
                    <x-stencil::dropdown-menu.item disabled>Payouts</x-stencil::dropdown-menu.item>
                </x-stencil::dropdown-menu.group>
            </x-stencil::dropdown-menu.content>
        </x-stencil::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('data-dropdown-menu-group')
        ->toContain('Billing')
        ->toContain('href="/invoices"')
        ->toContain('data-disabled="true"')
        ->toContain('Payouts');
});

it('marks menu content as a closed menu region for the widget script', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dropdown-menu>
            <x-stencil::dropdown-menu.trigger>
                <button type="button">Open</button>
            </x-stencil::dropdown-menu.trigger>
            <x-stencil::dropdown-menu.content>
                <x-stencil::dropdown-menu.item>One</x-stencil::dropdown-menu.item>
            </x-stencil::dropdown-menu.content>
        </x-stencil::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('role="menu"')
        ->toContain('tabindex="-1"')
        ->toContain('data-state="closed"')
        ->toContain('hidden');
});
