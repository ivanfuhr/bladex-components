<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Stencil;

it('resolves the singleton', function () {
    expect(app(Stencil::class))->toBeInstanceOf(Stencil::class);
});

it('returns the same instance from the container', function () {
    expect(app(Stencil::class))->toBe(app(Stencil::class));
});

it('merges the package config', function () {
    expect(config('stencil.placeholder'))->toBe('default');
});

it('loads the package translations', function () {
    expect(trans('stencil::messages.placeholder'))->toBe('Stencil placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('stencil::placeholder'))->toBeTrue();
});

it('renders the placeholder view with typography components', function () {
    $html = view('stencil::placeholder')->render();

    expect($html)
        ->toContain('data-heading')
        ->toContain('data-text')
        ->toContain('Stencil placeholder translation.');
});
