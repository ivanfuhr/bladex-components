<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an empty state with media, title, description, and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::empty class="border">
            <x-std::empty.header>
                <x-std::empty.media variant="icon" icon="file" />
                <x-std::empty.title>No projects yet</x-std::empty.title>
                <x-std::empty.description>Get started by creating a project.</x-std::empty.description>
            </x-std::empty.header>
            <x-std::empty.content>
                <button type="button">Create project</button>
            </x-std::empty.content>
        </x-std::empty>
    BLADE);

    expect($html)
        ->toContain('data-empty')
        ->toContain('role="status"')
        ->toContain('border-dashed')
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
        <x-std::empty>
            <x-std::empty.header>
                <x-std::empty.media>
                    <span data-custom-media>Avatar</span>
                </x-std::empty.media>
                <x-std::empty.title level="2">Inbox zero</x-std::empty.title>
            </x-std::empty.header>
        </x-std::empty>
    BLADE);

    expect($html)
        ->toContain('data-variant="default"')
        ->toContain('data-custom-media')
        ->toContain('Avatar')
        ->toContain('<h2')
        ->toContain('Inbox zero');
});
