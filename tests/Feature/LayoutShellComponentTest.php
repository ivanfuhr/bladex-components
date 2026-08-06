<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a page header variant for hero toolbars', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::header variant="page" :border="false">
            <div>Title block</div>
            <div>Actions</div>
        </x-std::header>
    BLADE);

    expect($html)
        ->toContain('data-header-variant="page"')
        ->toContain('md:flex-row')
        ->toContain('Title block')
        ->toContain('Actions')
        ->not->toContain('border-b');
});

it('renders shell header variant by default', function () {
    $html = Blade::render('<x-std::header>Toolbar</x-std::header>');

    expect($html)
        ->toContain('data-header-variant="shell"')
        ->toContain('h-16')
        ->toContain('border-b')
        ->toContain('bg-white')
        ->not->toContain('backdrop-blur')
        ->not->toContain('bg-white/90');
});

it('renders a layout main content landmark', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::main container>
            <p>Body</p>
        </x-std::main>
    BLADE);

    expect($html)
        ->toContain('data-main')
        ->toContain('app-main')
        ->toContain('app-main__content')
        ->toContain('data-scroll-area')
        ->toContain('data-scroll-area-viewport')
        ->toContain('data-scroll-area-scrollbar')
        ->toContain('max-w-7xl')
        ->toContain('p-4')
        ->not->toContain('pt-0')
        ->not->toContain('overflow-y-auto')
        ->toContain('Body');
});

it('forwards landmark attributes to main and content classes to the scroll body', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::main id="app-main" tabindex="-1" aria-label="Primary" class="gap-8" type="always">
            <p>Body</p>
        </x-std::main>
    BLADE);

    expect($html)
        ->toContain('id="app-main"')
        ->toContain('tabindex="-1"')
        ->toContain('aria-label="Primary"')
        ->toContain('data-scroll-area-type="always"')
        ->toContain('gap-8')
        ->toContain('Body');

    preg_match('/<main\b[^>]*>/', $html, $mainTag);
    preg_match('/class="([^"]*app-main__content[^"]*)"/', $html, $contentClass);

    expect($mainTag[0] ?? '')
        ->toContain('id="app-main"')
        ->toContain('aria-label="Primary"')
        ->and($contentClass[1] ?? '')->toContain('gap-8')
        ->and($contentClass[1] ?? '')->not->toContain('aria-label');
});

it('renders sidebar brand, spacer, and collapse controls', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar collapsible="icon">
                <x-std::sidebar.header>
                    <x-std::sidebar.brand href="/" name="Acme Inc.">
                        <x-slot:logo><span>S</span></x-slot:logo>
                    </x-std::sidebar.brand>
                    <x-std::sidebar.collapse />
                </x-std::sidebar.header>
                <x-std::sidebar.content>Nav</x-std::sidebar.content>
                <x-std::sidebar.spacer />
            </x-std::sidebar>
            <x-std::sidebar.inset>
                <x-std::header>
                    <x-std::sidebar.trigger />
                </x-std::header>
                <x-std::main>Content</x-std::main>
            </x-std::sidebar.inset>
        </x-std::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-brand')
        ->toContain('data-sidebar-spacer')
        ->toContain('data-sidebar-trigger')
        ->toContain('data-header')
        ->toContain('data-main')
        ->toContain('group/sidebar-wrapper')
        ->toContain('--std-sidebar-width-icon: 3.5rem')
        ->toContain('h-16')
        ->toContain('Acme Inc.')
        ->toContain('Content');
});

it('renders sidebar brand with logo url and dark variant', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar collapsible="icon">
                <x-std::sidebar.header>
                    <x-std::sidebar.brand
                        href="/"
                        name="Acme Inc."
                        logo="/logo-light.svg"
                        logo-dark="/logo-dark.svg"
                        alt="Acme"
                    />
                </x-std::sidebar.header>
            </x-std::sidebar>
        </x-std::sidebar.provider>
    BLADE);

    expect($html)
        ->toContain('data-sidebar-brand')
        ->toContain('Acme Inc.')
        ->toContain('src="/logo-light.svg"')
        ->toContain('src="/logo-dark.svg"')
        ->toContain('alt="Acme"')
        ->toContain('dark:hidden')
        ->toContain('hidden dark:block');
});
