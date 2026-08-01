<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a sidebar provider with shell landmarks and trigger', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::sidebar.provider storage-key="test-sidebar" :default-open="true">
            <x-stencil::sidebar collapsible="icon">
                <x-stencil::sidebar.header>Brand</x-stencil::sidebar.header>
                <x-stencil::sidebar.content>
                    <x-stencil::sidebar.group>
                        <x-stencil::sidebar.group-label>Platform</x-stencil::sidebar.group-label>
                        <x-stencil::sidebar.group-content>
                            <x-stencil::sidebar.menu>
                                <x-stencil::sidebar.menu-item>
                                    <x-stencil::sidebar.menu-button href="/" active>Home</x-stencil::sidebar.menu-button>
                                </x-stencil::sidebar.menu-item>
                            </x-stencil::sidebar.menu>
                        </x-stencil::sidebar.group-content>
                    </x-stencil::sidebar.group>
                </x-stencil::sidebar.content>
                <x-stencil::sidebar.footer>Account</x-stencil::sidebar.footer>
                <x-stencil::sidebar.rail />
            </x-stencil::sidebar>
            <x-stencil::sidebar.inset>
                <x-stencil::sidebar.trigger />
                <p>Main</p>
            </x-stencil::sidebar.inset>
        </x-stencil::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-provider')
        ->toContain('data-storage-key="test-sidebar"')
        ->toContain('data-default-open="true"')
        ->toContain('data-sidebar-root')
        ->toContain('data-collapsible-mode="icon"')
        ->toContain('data-sidebar-header')
        ->toContain('data-sidebar-content')
        ->toContain('data-sidebar-footer')
        ->toContain('data-sidebar-group-label')
        ->toContain('data-sidebar-menu-button')
        ->toContain('data-active="true"')
        ->toContain('aria-current="page"')
        ->toContain('data-sidebar-rail')
        ->toContain('data-sidebar-backdrop')
        ->toContain('data-sidebar-inset')
        ->toContain('data-sidebar-trigger')
        ->toContain('aria-expanded')
        ->toContain('role="navigation"')
        ->toContain('Home')
        ->toContain('Main');
});

it('supports offcanvas and inset variants on the sidebar root', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::sidebar.provider>
            <x-stencil::sidebar collapsible="offcanvas" variant="inset" side="right">
                <x-stencil::sidebar.content>Nav</x-stencil::sidebar.content>
            </x-stencil::sidebar>
            <x-stencil::sidebar.inset>Body</x-stencil::sidebar.inset>
        </x-stencil::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-mode="offcanvas"')
        ->toContain('data-variant="inset"')
        ->toContain('data-side="right"')
        ->toContain('data-sidebar-inset')
        ->toContain('Nav')
        ->toContain('Body');
});

it('renders a non-collapsible sidebar without backdrop or rail chrome', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::sidebar collapsible="none">
            <x-stencil::sidebar.content>Static</x-stencil::sidebar.content>
        </x-stencil::sidebar>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-mode="none"')
        ->toContain('Static')
        ->not->toContain('data-sidebar-backdrop')
        ->not->toContain('data-sidebar-gap');
});

it('renders menu actions, badges, and nested submenus', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::sidebar.provider>
            <x-stencil::sidebar>
                <x-stencil::sidebar.content>
                    <x-stencil::sidebar.menu>
                        <x-stencil::sidebar.menu-item>
                            <x-stencil::sidebar.menu-button href="#">Projects</x-stencil::sidebar.menu-button>
                            <x-stencil::sidebar.menu-action aria-label="Add project">+</x-stencil::sidebar.menu-action>
                            <x-stencil::sidebar.menu-badge>3</x-stencil::sidebar.menu-badge>
                            <x-stencil::sidebar.menu-sub>
                                <x-stencil::sidebar.menu-sub-item>
                                    <x-stencil::sidebar.menu-sub-button href="#" active>Alpha</x-stencil::sidebar.menu-sub-button>
                                </x-stencil::sidebar.menu-sub-item>
                            </x-stencil::sidebar.menu-sub>
                        </x-stencil::sidebar.menu-item>
                    </x-stencil::sidebar.menu>
                    <x-stencil::sidebar.separator />
                </x-stencil::sidebar.content>
            </x-stencil::sidebar>
        </x-stencil::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-menu-action')
        ->toContain('data-sidebar-menu-badge')
        ->toContain('data-sidebar-menu-sub')
        ->toContain('data-sidebar-menu-sub-button')
        ->toContain('data-sidebar-separator')
        ->toContain('role="separator"')
        ->toContain('Alpha')
        ->toContain('aria-current="page"');
});

it('supports as-child trigger wrapping', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::sidebar.provider>
            <x-stencil::sidebar.trigger as-child>
                <x-stencil::button variant="outline" square>Toggle</x-stencil::button>
            </x-stencil::sidebar.trigger>
        </x-stencil::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-trigger')
        ->toContain('contents')
        ->toContain('Toggle');
});
