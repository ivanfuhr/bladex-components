<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;

it('renders a rating with hidden input and stars', function () {
    $html = Blade::render('<x-ui::rating name="score" :value="3" :max="5" />');

    expect($html)
        ->toContain('data-rating')
        ->toContain('name="score"')
        ->toContain('value="3"')
        ->toContain('data-rating-star')
        ->toContain('role="radiogroup"')
        ->toContain('role="radio"')
        ->toContain('aria-checked="true"')
        ->toContain('text-zinc-500')
        ->toContain('!text-amber-700');
});

it('requires a name attribute', function () {
    Blade::render('<x-ui::rating />');
})->throws(ViewException::class);
