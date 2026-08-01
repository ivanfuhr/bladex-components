<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a breadcrumb trail with links and current page', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::breadcrumb>
            <x-stencil::breadcrumb.list>
                <x-stencil::breadcrumb.item>
                    <x-stencil::breadcrumb.link href="/">Home</x-stencil::breadcrumb.link>
                </x-stencil::breadcrumb.item>
                <x-stencil::breadcrumb.separator />
                <x-stencil::breadcrumb.item>
                    <x-stencil::breadcrumb.page>Settings</x-stencil::breadcrumb.page>
                </x-stencil::breadcrumb.item>
            </x-stencil::breadcrumb.list>
        </x-stencil::breadcrumb>
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
        <x-stencil::breadcrumb>
            <x-stencil::breadcrumb.list>
                <x-stencil::breadcrumb.item href="/blog">Blog</x-stencil::breadcrumb.item>
                <x-stencil::breadcrumb.separator type="slash" />
                <x-stencil::breadcrumb.item>
                    <x-stencil::breadcrumb.page>Post</x-stencil::breadcrumb.page>
                </x-stencil::breadcrumb.item>
            </x-stencil::breadcrumb.list>
        </x-stencil::breadcrumb>
    BLADE);

    expect($html)
        ->toContain('href="/blog"')
        ->toContain('Blog')
        ->toContain('/')
        ->toContain('Post');
});

it('renders ellipsis for collapsed trails', function () {
    $html = Blade::render('<x-stencil::breadcrumb.ellipsis />');

    expect($html)
        ->toContain('data-breadcrumb-ellipsis')
        ->toContain('…')
        ->toContain('sr-only');
});
