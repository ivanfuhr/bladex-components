<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an avatar image with fallback initials from name', function () {
    $html = Blade::render('<x-std::avatar src="https://example.com/a.jpg" name="Caleb Porzio" circle size="lg" />');

    expect($html)
        ->toContain('data-avatar')
        ->toContain('data-avatar-image')
        ->toContain('data-avatar-fallback')
        ->toContain('src="https://example.com/a.jpg"')
        ->toContain('alt="Caleb Porzio"')
        ->toContain('CP')
        ->toContain('rounded-full')
        ->toContain('size-12');
});

it('renders initials-only avatar with color', function () {
    $html = Blade::render('<x-std::avatar name="Ada Lovelace" color="violet" initials="AL" />');

    expect($html)
        ->toContain('AL')
        ->toContain('bg-violet-100')
        ->toContain('role="img"')
        ->toContain('aria-label="Ada Lovelace"')
        ->not->toContain('data-avatar-image');
});

it('supports compound image and fallback composition', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::avatar size="sm">
            <x-std::avatar.image src="/me.jpg" alt="Me" />
            <x-std::avatar.fallback>ME</x-std::avatar.fallback>
        </x-std::avatar>
    BLADE);

    expect($html)
        ->toContain('src="/me.jpg"')
        ->toContain('alt="Me"')
        ->toContain('ME')
        ->toContain('size-8');
});

it('renders avatar groups with overlapping rings', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::avatar.group>
            <x-std::avatar name="One" />
            <x-std::avatar name="Two" />
        </x-std::avatar.group>
    BLADE);

    expect($html)
        ->toContain('data-avatar-group')
        ->toContain('-space-x-2')
        ->toContain('data-avatar');
});

it('renders avatar group labels when provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::avatar.group label="Project contributors">
            <x-std::avatar name="One" />
            <x-std::avatar name="Two" />
        </x-std::avatar.group>
    BLADE);

    expect($html)
        ->toContain('aria-label="Project contributors"')
        ->toContain('role="group"');
});
