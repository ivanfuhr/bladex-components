<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an empty state with media, title, description, and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::empty class="border">
            <x-ui::empty.header>
                <x-ui::empty.media variant="icon" icon="file" />
                <x-ui::empty.title>No projects yet</x-ui::empty.title>
                <x-ui::empty.description>Get started by creating a project.</x-ui::empty.description>
            </x-ui::empty.header>
            <x-ui::empty.content>
                <button type="button">Create project</button>
            </x-ui::empty.content>
        </x-ui::empty>
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
        <x-ui::empty>
            <x-ui::empty.header>
                <x-ui::empty.media>
                    <span data-custom-media>Avatar</span>
                </x-ui::empty.media>
                <x-ui::empty.title level="2">Inbox zero</x-ui::empty.title>
            </x-ui::empty.header>
        </x-ui::empty>
    BLADE);

    expect($html)
        ->toContain('data-variant="default"')
        ->toContain('data-custom-media')
        ->toContain('Avatar')
        ->toContain('<h2')
        ->toContain('Inbox zero');
});
