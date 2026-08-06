<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dropdown menu with trigger content and items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dropdown-menu align="end">
            <x-std::dropdown-menu.trigger>
                <x-std::button variant="outline">Open</x-std::button>
            </x-std::dropdown-menu.trigger>
            <x-std::dropdown-menu.content>
                <x-std::dropdown-menu.label>Account</x-std::dropdown-menu.label>
                <x-std::dropdown-menu.item>Profile</x-std::dropdown-menu.item>
                <x-std::dropdown-menu.separator />
                <x-std::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-std::dropdown-menu.item>
            </x-std::dropdown-menu.content>
        </x-std::dropdown-menu>
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
        ->toContain('focus:bg-red-50')
        ->toContain('data-[highlighted]:bg-red-50')
        ->toContain('⌘⌫')
        ->toContain('Delete')
        // Root must not shrink-wrap; contents lets w-full triggers fill the parent (e.g. sidebar).
        ->toContain('class="dropdown-menu contents"');
});

it('supports grouped items and disabled state', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dropdown-menu>
            <x-std::dropdown-menu.trigger>
                <button type="button">Menu</button>
            </x-std::dropdown-menu.trigger>
            <x-std::dropdown-menu.content>
                <x-std::dropdown-menu.group heading="Billing">
                    <x-std::dropdown-menu.item href="/invoices">Invoices</x-std::dropdown-menu.item>
                    <x-std::dropdown-menu.item disabled>Payouts</x-std::dropdown-menu.item>
                </x-std::dropdown-menu.group>
            </x-std::dropdown-menu.content>
        </x-std::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('data-dropdown-menu-group')
        ->toMatch('/aria-labelledby="[^"]+"/')
        ->toContain('Billing')
        ->toContain('href="/invoices"')
        ->toContain('data-disabled="true"')
        ->toContain('Payouts');
});

it('marks menu content as a closed menu region for the widget script', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dropdown-menu>
            <x-std::dropdown-menu.trigger>
                <button type="button">Open</button>
            </x-std::dropdown-menu.trigger>
            <x-std::dropdown-menu.content>
                <x-std::dropdown-menu.item>One</x-std::dropdown-menu.item>
            </x-std::dropdown-menu.content>
        </x-std::dropdown-menu>
    BLADE);

    expect($html)
        ->toContain('role="menu"')
        ->toContain('aria-orientation="vertical"')
        ->toContain('tabindex="-1"')
        ->toContain('data-state="closed"')
        ->toContain('aria-hidden="true"')
        ->toContain('inert')
        ->toContain('hidden');
});

it('dropdown menu script removes orphaned portaled content on remount', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain('[data-dropdown-menu-content][data-dropdown-menu-portaled]')
        ->toContain("content.closest('[data-dropdown-menu]')")
        ->toContain('content.remove()')
        ->toContain('createBindSignal')
        ->toContain('std:mount');
});

it('dropdown menu script locks page scroll while open instead of closing on scroll', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain('acquireBodyScrollLock')
        ->toContain('releaseScrollLock')
        ->not->toContain('onScroll')
        ->not->toContain("window.addEventListener('scroll', onScroll, { capture: true, signal })")
        ->not->toContain("window.addEventListener('scroll', reposition, { capture: true, signal })");
});

it('dropdown menu script toggles inert and aria-hidden with open state', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain("content.removeAttribute('inert')")
        ->toContain("content.removeAttribute('aria-hidden')")
        ->toContain("content.setAttribute('inert', '')")
        ->toContain("content.setAttribute('aria-hidden', 'true')");
});

it('dropdown menu script positions left and right sides beside the trigger', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dropdown-menu.js');

    expect($source)
        ->toContain("side === 'left' || side === 'right'")
        ->toContain('rect.right + gap')
        ->toContain('rect.left - gap - width')
        ->toContain('rect.bottom - height');
});
