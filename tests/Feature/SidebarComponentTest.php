<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('reflects provider default-open on trigger aria-expanded', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider :default-open="false">
            <x-std::sidebar.trigger />
        </x-std::sidebar.provider>
    BLADE);

    expect($html)->toContain('aria-expanded="false"');
});

it('renders a sidebar provider with shell landmarks and trigger', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider storage-key="test-sidebar" :default-open="true">
            <x-std::sidebar collapsible="icon">
                <x-std::sidebar.header>Brand</x-std::sidebar.header>
                <x-std::sidebar.content>
                    <x-std::sidebar.group>
                        <x-std::sidebar.group-label>Platform</x-std::sidebar.group-label>
                        <x-std::sidebar.group-content>
                            <x-std::sidebar.menu>
                                <x-std::sidebar.menu-item>
                                    <x-std::sidebar.menu-button href="/" active>Home</x-std::sidebar.menu-button>
                                </x-std::sidebar.menu-item>
                            </x-std::sidebar.menu>
                        </x-std::sidebar.group-content>
                    </x-std::sidebar.group>
                </x-std::sidebar.content>
                <x-std::sidebar.footer>Account</x-std::sidebar.footer>
                <x-std::sidebar.rail />
            </x-std::sidebar>
            <x-std::sidebar.inset>
                <x-std::sidebar.trigger />
                <p>Main</p>
            </x-std::sidebar.inset>
        </x-std::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-provider')
        ->toContain('data-storage-key="test-sidebar"')
        ->toContain('data-default-open="true"')
        ->toContain('data-sidebar-root')
        ->toContain('data-collapsible-mode="icon"')
        ->toContain('data-sidebar-header')
        ->toContain('data-sidebar-content')
        ->toContain('data-scroll-area')
        ->toContain('data-scroll-area-viewport')
        ->toContain('data-scroll-area-scrollbar')
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
        ->toContain('Main')
        ->not->toContain('overflow-y-auto');
});

it('forwards scroll-area options and body classes on sidebar content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.content class="gap-0" type="always" :scroll-hide-delay="200" aria-label="Docs navigation">
            <p>Nav</p>
        </x-std::sidebar.content>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-content')
        ->toContain('data-scroll-area-type="always"')
        ->toContain('data-scroll-area-hide-delay="200"')
        ->toContain('aria-label="Docs navigation"')
        ->toContain('gap-0')
        ->toContain('Nav')
        ->not->toContain('overflow-y-auto');
});

it('supports offcanvas and inset variants on the sidebar root', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar collapsible="offcanvas" variant="inset" side="right">
                <x-std::sidebar.content>Nav</x-std::sidebar.content>
            </x-std::sidebar>
            <x-std::sidebar.inset>Body</x-std::sidebar.inset>
        </x-std::sidebar.provider>
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
        <x-std::sidebar collapsible="none">
            <x-std::sidebar.content>Static</x-std::sidebar.content>
        </x-std::sidebar>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-mode="none"')
        ->toContain('Static')
        ->not->toContain('data-sidebar-backdrop')
        ->not->toContain('data-sidebar-gap');
});

it('renders menu actions, badges, and nested submenus', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar>
                <x-std::sidebar.content>
                    <x-std::sidebar.menu>
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button href="#">Projects</x-std::sidebar.menu-button>
                            <x-std::sidebar.menu-action aria-label="Add project">+</x-std::sidebar.menu-action>
                            <x-std::sidebar.menu-badge>3</x-std::sidebar.menu-badge>
                            <x-std::sidebar.menu-sub>
                                <x-std::sidebar.menu-sub-item>
                                    <x-std::sidebar.menu-sub-button href="#" active>Alpha</x-std::sidebar.menu-sub-button>
                                </x-std::sidebar.menu-sub-item>
                            </x-std::sidebar.menu-sub>
                        </x-std::sidebar.menu-item>
                    </x-std::sidebar.menu>
                    <x-std::sidebar.separator />
                </x-std::sidebar.content>
            </x-std::sidebar>
        </x-std::sidebar.provider>
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
        <x-std::sidebar.provider>
            <x-std::sidebar.trigger as-child>
                <x-std::button variant="outline" square>Toggle</x-std::button>
            </x-std::sidebar.trigger>
        </x-std::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-trigger')
        ->toContain('contents')
        ->toContain('Toggle');
});

it('wraps menu buttons with icon-mode tooltips and stronger active chrome', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar collapsible="icon">
                <x-std::sidebar.content>
                    <x-std::sidebar.menu>
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button href="/" active tooltip="Home">
                                Home
                            </x-std::sidebar.menu-button>
                            <x-std::sidebar.menu-badge>12</x-std::sidebar.menu-badge>
                        </x-std::sidebar.menu-item>
                    </x-std::sidebar.menu>
                </x-std::sidebar.content>
            </x-std::sidebar>
        </x-std::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-menu-tooltip')
        ->toContain('data-tooltip')
        ->toContain('data-tooltip-content')
        ->toContain('data-[active=true]:bg-zinc-900')
        ->toContain('group-data-[collapsible=icon]:rounded-full')
        ->toContain('group-has-data-[active=true]/menu-item:text-zinc-50')
        ->toContain('contents!')
        ->toContain('Home');
});

it('sidebar script tears down document and matchMedia listeners with createBindSignal', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/sidebar.js');

    expect($source)
        ->toContain('createBindSignal')
        ->toContain("document.addEventListener('keydown', onKeydown, { signal })")
        ->toContain("media.addEventListener('change', onMediaChange, { signal })")
        ->toContain('std:mount');
});

it('tooltip script gates sidebar menu tooltips to icon-collapsed mode', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/tooltip.js');

    expect($source)
        ->toContain('isSidebarMenuTooltipDisabled')
        ->toContain('data-sidebar-menu-tooltip')
        ->toContain("dataset.collapsible !== 'icon'")
        ->toContain('focusin')
        ->toContain('focusout')
        ->toContain('resolveControl');
});
