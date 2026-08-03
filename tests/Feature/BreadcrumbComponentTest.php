<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a breadcrumb trail with links and current page', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::breadcrumb>
            <x-ui::breadcrumb.list>
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.link href="/">Home</x-ui::breadcrumb.link>
                </x-ui::breadcrumb.item>
                <x-ui::breadcrumb.separator />
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.page>Settings</x-ui::breadcrumb.page>
                </x-ui::breadcrumb.item>
            </x-ui::breadcrumb.list>
        </x-ui::breadcrumb>
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
        <x-ui::breadcrumb>
            <x-ui::breadcrumb.list>
                <x-ui::breadcrumb.item href="/blog">Blog</x-ui::breadcrumb.item>
                <x-ui::breadcrumb.separator type="slash" />
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.page>Post</x-ui::breadcrumb.page>
                </x-ui::breadcrumb.item>
            </x-ui::breadcrumb.list>
        </x-ui::breadcrumb>
    BLADE);

    expect($html)
        ->toContain('href="/blog"')
        ->toContain('Blog')
        ->toContain('/')
        ->toContain('Post');
});

it('renders ellipsis for collapsed trails', function () {
    $html = Blade::render('<x-ui::breadcrumb.ellipsis />');

    expect($html)
        ->toContain('data-breadcrumb-ellipsis')
        ->toContain('…')
        ->toContain('sr-only');
});
