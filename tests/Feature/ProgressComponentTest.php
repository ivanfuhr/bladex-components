<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a determinate progress bar', function () {
    $html = Blade::render('<x-stencil::progress :value="40" :max="100" />');

    expect($html)
        ->toContain('role="progressbar"')
        ->toContain('aria-valuenow="40"')
        ->toContain('aria-valuemax="100"')
        ->toContain('width: 40%')
        ->toContain('data-progress');
});

it('renders an indeterminate progress bar', function () {
    $html = Blade::render('<x-stencil::progress indeterminate />');

    expect($html)
        ->toContain('data-indeterminate="true"')
        ->not->toContain('aria-valuenow');
});
