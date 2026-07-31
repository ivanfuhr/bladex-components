<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;

it('renders a color picker with trigger, popover, and swatches', function () {
    $html = Blade::render('<x-stencil::color-picker name="brand_color" value="#3366cc" />');

    expect($html)
        ->toContain('data-color-picker')
        ->toContain('data-color-picker-swatch-trigger')
        ->toContain('data-color-picker-popover')
        ->toContain('data-color-picker-area')
        ->toContain('data-color-picker-hue')
        ->toContain('data-color-picker-swatches')
        ->toContain('data-color-picker-hex')
        ->toContain('name="brand_color"')
        ->toContain('value="#3366cc"')
        ->toContain('#3366CC');
});

it('can hide swatches and enable the dropper', function () {
    $html = Blade::render('<x-stencil::color-picker name="brand_color" :swatches="false" :dropper="true" />');

    expect($html)
        ->not->toContain('data-color-picker-swatches')
        ->toContain('data-color-picker-dropper');
});

it('requires a name attribute', function () {
    Blade::render('<x-stencil::color-picker />');
})->throws(ViewException::class);
