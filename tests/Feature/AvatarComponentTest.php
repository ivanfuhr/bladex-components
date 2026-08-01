<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an avatar image with fallback initials from name', function () {
    $html = Blade::render('<x-stencil::avatar src="https://example.com/a.jpg" name="Caleb Porzio" circle size="lg" />');

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
    $html = Blade::render('<x-stencil::avatar name="Ada Lovelace" color="violet" initials="AL" />');

    expect($html)
        ->toContain('AL')
        ->toContain('bg-violet-100')
        ->not->toContain('data-avatar-image');
});

it('supports compound image and fallback composition', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::avatar size="sm">
            <x-stencil::avatar.image src="/me.jpg" alt="Me" />
            <x-stencil::avatar.fallback>ME</x-stencil::avatar.fallback>
        </x-stencil::avatar>
    BLADE);

    expect($html)
        ->toContain('src="/me.jpg"')
        ->toContain('alt="Me"')
        ->toContain('ME')
        ->toContain('size-8');
});

it('renders avatar groups with overlapping rings', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::avatar.group>
            <x-stencil::avatar name="One" />
            <x-stencil::avatar name="Two" />
        </x-stencil::avatar.group>
    BLADE);

    expect($html)
        ->toContain('data-avatar-group')
        ->toContain('-space-x-2')
        ->toContain('data-avatar');
});
