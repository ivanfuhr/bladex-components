<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a card with header content and footer', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::card>
            <x-stencil::card.header>
                <x-stencil::card.title>Account</x-stencil::card.title>
                <x-stencil::card.description>Manage your profile.</x-stencil::card.description>
            </x-stencil::card.header>
            <x-stencil::card.content>Body</x-stencil::card.content>
            <x-stencil::card.footer>Actions</x-stencil::card.footer>
        </x-stencil::card>
    BLADE);

    expect($html)
        ->toContain('data-card')
        ->toContain('data-card-header')
        ->toContain('data-card-title')
        ->toContain('Account')
        ->toContain('Manage your profile.')
        ->toContain('data-card-content')
        ->toContain('Body')
        ->toContain('data-card-footer')
        ->toContain('Actions');
});

it('supports small card size', function () {
    $html = Blade::render('<x-stencil::card size="sm">Compact</x-stencil::card>');

    expect($html)
        ->toContain('data-size="sm"')
        ->toContain('p-4')
        ->toContain('Compact');
});
