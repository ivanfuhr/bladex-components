<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a breadcrumb trail with links and current page', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::breadcrumb>
            <x-std::breadcrumb.list>
                <x-std::breadcrumb.item>
                    <x-std::breadcrumb.link href="/">Home</x-std::breadcrumb.link>
                </x-std::breadcrumb.item>
                <x-std::breadcrumb.separator />
                <x-std::breadcrumb.item>
                    <x-std::breadcrumb.page>Settings</x-std::breadcrumb.page>
                </x-std::breadcrumb.item>
            </x-std::breadcrumb.list>
        </x-std::breadcrumb>
    BLADE);

    expect($html)
        ->toContain('data-breadcrumb')
        ->toContain('aria-label="Breadcrumb"')
        ->toContain('data-breadcrumb-list')
        ->toContain('href="/"')
        ->toContain('Home')
        ->toContain('aria-current="page"')
        ->toContain('Settings')
        ->toContain('data-breadcrumb-separator');
});

it('supports flux-style item href shorthand and slash separators', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::breadcrumb>
            <x-std::breadcrumb.list>
                <x-std::breadcrumb.item href="/blog">Blog</x-std::breadcrumb.item>
                <x-std::breadcrumb.separator type="slash" />
                <x-std::breadcrumb.item>
                    <x-std::breadcrumb.page>Post</x-std::breadcrumb.page>
                </x-std::breadcrumb.item>
            </x-std::breadcrumb.list>
        </x-std::breadcrumb>
    BLADE);

    expect($html)
        ->toContain('href="/blog"')
        ->toContain('Blog')
        ->toContain('/')
        ->toContain('Post');
});

it('allows responsive hiding via consumer classes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::breadcrumb>
            <x-std::breadcrumb.list>
                <x-std::breadcrumb.item class="max-md:hidden">
                    <x-std::breadcrumb.link href="/">Home</x-std::breadcrumb.link>
                </x-std::breadcrumb.item>
                <x-std::breadcrumb.item class="min-w-0 overflow-hidden">
                    <x-std::breadcrumb.page>Current</x-std::breadcrumb.page>
                </x-std::breadcrumb.item>
            </x-std::breadcrumb.list>
        </x-std::breadcrumb>
    BLADE);

    expect($html)
        ->toContain('max-md:hidden')
        ->toContain('flex-nowrap')
        ->toContain('breadcrumb__page')
        ->toContain('truncate');
});

it('renders ellipsis for collapsed trails', function () {
    $html = Blade::render('<x-std::breadcrumb.ellipsis />');

    expect($html)
        ->toContain('data-breadcrumb-ellipsis')
        ->toContain('…')
        ->toContain('sr-only');
});
