<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a card with header content and footer', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::card>
            <x-ui::card.header>
                <x-ui::card.title>Account</x-ui::card.title>
                <x-ui::card.description>Manage your profile.</x-ui::card.description>
            </x-ui::card.header>
            <x-ui::card.content>Body</x-ui::card.content>
            <x-ui::card.footer>Actions</x-ui::card.footer>
        </x-ui::card>
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
    $html = Blade::render('<x-ui::card size="sm">Compact</x-ui::card>');

    expect($html)
        ->toContain('data-size="sm"')
        ->toContain('p-4')
        ->toContain('Compact');
});
