<?php

declare(strict_types=1);

use Ivanfuhr\StdComponents\StdComponents;

it('resolves the singleton', function () {
    expect(app(StdComponents::class))->toBeInstanceOf(StdComponents::class);
});

it('returns the same instance from the container', function () {
    expect(app(StdComponents::class))->toBe(app(StdComponents::class));
});

it('merges the package config', function () {
    expect(config('std-components.typography.defaults.text_size'))->toBe('default');
});

it('renders inline translation strings in placeholder view', function () {
    expect(__('Std Components'))->toBe('Std Components');
    expect(__('Std Components placeholder translation.'))->toBe('Std Components placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('std-components::placeholder'))->toBeTrue();
});

it('renders the placeholder view with typography components', function () {
    $html = view('std-components::placeholder')->render();

    expect($html)
        ->toContain('data-heading')
        ->toContain('data-text')
        ->toContain('Std Components placeholder translation.');
});
