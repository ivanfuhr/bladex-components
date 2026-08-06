<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a label with for attribute and data marker', function () {
    $html = Blade::render('<x-std::label for="email">Email</x-std::label>');

    expect($html)
        ->toContain('data-label')
        ->toContain('for="email"')
        ->toContain('Email');
});

it('renders optional badge and required indicator', function () {
    $html = Blade::render('<x-std::label for="email" badge="Required" :required="true">Email</x-std::label>');

    expect($html)
        ->toContain('data-label-badge')
        ->toContain('Required')
        ->toContain('aria-hidden="true"');
});
