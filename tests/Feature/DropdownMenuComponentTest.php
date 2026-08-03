<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dropdown menu with trigger content and items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::dropdown-menu align="end">
            <x-ui::dropdown-menu.trigger>
                <x-ui::button variant="outline">Open</x-ui::button>
            </x-ui::dropdown-menu.trigger>
            <x-ui::dropdown-menu.content>
                <x-ui::dropdown-menu.label>Account</x-ui::dropdown-menu.label>
                <x-ui::dropdown-menu.item>Profile</x-ui::dropdown-menu.item>
                <x-ui::dropdown-menu.separator />
                <x-ui::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-ui::dropdown-menu.item>
            </x-ui::dropdown-menu.content>
        </x-ui::dropdown-menu>
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
        <x-ui::dropdown-menu>
            <x-ui::dropdown-menu.trigger>
                <button type="button">Menu</button>
            </x-ui::dropdown-menu.trigger>
            <x-ui::dropdown-menu.content>
                <x-ui::dropdown-menu.group heading="Billing">
                    <x-ui::dropdown-menu.item href="/invoices">Invoices</x-ui::dropdown-menu.item>
                    <x-ui::dropdown-menu.item disabled>Payouts</x-ui::dropdown-menu.item>
                </x-ui::dropdown-menu.group>
            </x-ui::dropdown-menu.content>
        </x-ui::dropdown-menu>
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
        <x-ui::dropdown-menu>
            <x-ui::dropdown-menu.trigger>
                <button type="button">Open</button>
            </x-ui::dropdown-menu.trigger>
            <x-ui::dropdown-menu.content>
                <x-ui::dropdown-menu.item>One</x-ui::dropdown-menu.item>
            </x-ui::dropdown-menu.content>
        </x-ui::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('role="menu"')
        ->toContain('tabindex="-1"')
        ->toContain('data-state="closed"')
        ->toContain('hidden');
});

it('dropdown menu script removes orphaned portaled content on remount', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain('[data-dropdown-menu-content][data-dropdown-menu-portaled]')
        ->toContain("content.closest('[data-dropdown-menu]')")
        ->toContain('content.remove()')
        ->toContain('createBindSignal')
        ->toContain('stencil:mount');
});

it('dropdown menu script closes on external scroll instead of clamping to the viewport', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain('onScroll')
        ->toContain('content.contains(target)')
        ->toContain("window.addEventListener('scroll', onScroll, { capture: true, signal })")
        ->not->toContain("window.addEventListener('scroll', reposition, { capture: true, signal })");
});
