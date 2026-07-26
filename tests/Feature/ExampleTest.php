<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\BladexComponents;

it('resolves the singleton', function () {
    expect(app(BladexComponents::class))->toBeInstanceOf(BladexComponents::class);
});

it('returns the same instance from the container', function () {
    expect(app(BladexComponents::class))->toBe(app(BladexComponents::class));
});

it('merges the package config', function () {
    expect(config('bladex-components.placeholder'))->toBe('default');
});

it('loads the package translations', function () {
    expect(trans('bladex-components::messages.placeholder'))->toBe('BladexComponents placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('bladex-components::placeholder'))->toBeTrue();
});

it('registers the artisan command', function () {
    $this->artisan('bladex-components:placeholder')
        ->expectsOutputToContain('BladexComponents placeholder command executed.')
        ->assertSuccessful();
});
