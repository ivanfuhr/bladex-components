<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an empty state with media, title, description, and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::empty class="border">
            <x-stencil::empty.header>
                <x-stencil::empty.media variant="icon" icon="file" />
                <x-stencil::empty.title>No projects yet</x-stencil::empty.title>
                <x-stencil::empty.description>Get started by creating a project.</x-stencil::empty.description>
            </x-stencil::empty.header>
            <x-stencil::empty.content>
                <button type="button">Create project</button>
            </x-stencil::empty.content>
        </x-stencil::empty>
    BLADE);

    expect($html)
        ->toContain('data-empty')
        ->toContain('data-empty-header')
        ->toContain('data-empty-media')
        ->toContain('data-variant="icon"')
        ->toContain('data-empty-title')
        ->toContain('No projects yet')
        ->toContain('data-empty-description')
        ->toContain('Get started by creating a project.')
        ->toContain('data-empty-content')
        ->toContain('Create project');
});

it('supports default media variant without an icon prop', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::empty>
            <x-stencil::empty.header>
                <x-stencil::empty.media>
                    <span data-custom-media>Avatar</span>
                </x-stencil::empty.media>
                <x-stencil::empty.title level="2">Inbox zero</x-stencil::empty.title>
            </x-stencil::empty.header>
        </x-stencil::empty>
    BLADE);

    expect($html)
        ->toContain('data-variant="default"')
        ->toContain('data-custom-media')
        ->toContain('Avatar')
        ->toContain('<h2')
        ->toContain('Inbox zero');
});
