<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a card with header content and footer', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::card>
            <x-std::card.header>
                <x-std::card.title>Account</x-std::card.title>
                <x-std::card.description>Manage your profile.</x-std::card.description>
            </x-std::card.header>
            <x-std::card.content>Body</x-std::card.content>
            <x-std::card.footer>Actions</x-std::card.footer>
        </x-std::card>
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
    $html = Blade::render('<x-std::card size="sm">Compact</x-std::card>');

    expect($html)
        ->toContain('data-size="sm"')
        ->toContain('p-4')
        ->toContain('Compact');
});
