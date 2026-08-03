<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a label with for attribute and data marker', function () {
    $html = Blade::render('<x-ui::label for="email">Email</x-ui::label>');

    expect($html)
        ->toContain('data-label')
        ->toContain('for="email"')
        ->toContain('Email');
});

it('renders optional badge and required indicator', function () {
    $html = Blade::render('<x-ui::label for="email" badge="Required" :required="true">Email</x-ui::label>');

    expect($html)
        ->toContain('data-label-badge')
        ->toContain('Required')
        ->toContain('aria-hidden="true"');
});
