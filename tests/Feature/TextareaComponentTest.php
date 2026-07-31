<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a textarea control with name', function () {
    $html = Blade::render('<x-stencil::textarea name="bio" placeholder="Tell us about yourself">Hello</x-stencil::textarea>');

    expect($html)
        ->toContain('data-textarea')
        ->toContain('data-textarea-control')
        ->toContain('name="bio"')
        ->toContain('Hello');
});

it('marks textarea invalid when invalid prop is true', function () {
    $html = Blade::render('<x-stencil::textarea name="bio" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});

it('respects disabled on textarea', function () {
    $html = Blade::render('<x-stencil::textarea name="bio" disabled />');

    expect($html)->toContain('disabled');
});

it('renders autosize and counter markers', function () {
    $html = Blade::render('<x-stencil::textarea name="bio" autosize counter maxlength="200" />');

    expect($html)
        ->toContain('data-textarea-autosize')
        ->toContain('data-textarea-counter')
        ->toContain('data-textarea-counter-display')
        ->toContain('maxlength="200"');
});
