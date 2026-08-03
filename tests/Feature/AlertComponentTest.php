<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an alert with title and description', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::alert variant="warning" title="Heads up">
            <x-ui::alert.description>Check your billing details.</x-ui::alert.description>
        </x-ui::alert>
    BLADE);

    expect($html)
        ->toContain('role="alert"')
        ->toContain('data-alert')
        ->toContain('data-variant="warning"')
        ->toContain('Heads up')
        ->toContain('Check your billing details.');
});
