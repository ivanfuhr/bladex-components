<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;

it('renders a rating with hidden input and stars', function () {
    $html = Blade::render('<x-stencil::rating name="score" :value="3" :max="5" />');

    expect($html)
        ->toContain('data-rating')
        ->toContain('name="score"')
        ->toContain('value="3"')
        ->toContain('data-rating-star')
        ->toContain('role="slider"')
        ->toContain('aria-valuenow="3"');
});

it('requires a name attribute', function () {
    Blade::render('<x-stencil::rating />');
})->throws(ViewException::class);
