<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a brand with name and logo url', function () {
    $html = Blade::render('<x-std::brand href="/" name="Acme Inc." logo="/logo.svg" alt="Acme" />');

    expect($html)
        ->toContain('data-brand')
        ->toContain('href="/"')
        ->toContain('Acme Inc.')
        ->toContain('src="/logo.svg"')
        ->toContain('alt="Acme"');
});

it('renders a logo-only brand', function () {
    $html = Blade::render('<x-std::brand href="/home" logo="/logo.svg" />');

    expect($html)
        ->toContain('data-brand')
        ->toContain('href="/home"')
        ->toContain('src="/logo.svg"')
        ->not->toContain('Acme');
});

it('renders a brand with a custom logo slot', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::brand href="#" name="Launchpad">
            <x-slot:logo class="size-6 rounded-full bg-cyan-500 text-white text-xs font-bold">
                <span>R</span>
            </x-slot:logo>
        </x-std::brand>
    BLADE);

    expect($html)
        ->toContain('data-brand')
        ->toContain('Launchpad')
        ->toContain('rounded-full')
        ->toContain('>R<');
});

it('renders light and dark logo images', function () {
    $html = Blade::render('<x-std::brand logo="/logo-light.svg" logo-dark="/logo-dark.svg" alt="Brand" />');

    expect($html)
        ->toContain('src="/logo-light.svg"')
        ->toContain('src="/logo-dark.svg"')
        ->toContain('dark:hidden')
        ->toContain('hidden dark:block');
});

it('accepts logoDark as a constructor prop', function () {
    $html = Blade::render('<x-std::brand :logo-dark="\'/logo-dark.svg\'" logo="/logo-light.svg" />');

    expect($html)
        ->toContain('src="/logo-light.svg"')
        ->toContain('src="/logo-dark.svg"');
});
