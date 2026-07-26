<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders field error messages with alert role and error colors', function () {
    $html = Blade::render('<x-bladex-components::field.message variant="error">Too short.</x-bladex-components::field.message>');

    expect($html)
        ->toContain('data-field-message')
        ->toContain('data-field-message-variant="error"')
        ->toContain('role="alert"')
        ->toContain('text-red-600')
        ->toContain('Too short.');
});

it('renders hint messages without alert role', function () {
    $html = Blade::render('<x-bladex-components::field.message>Optional hint.</x-bladex-components::field.message>');

    expect($html)
        ->toContain('data-field-message-variant="hint"')
        ->not->toContain('role="alert"')
        ->toContain('text-zinc-500');
});

it('styles text variant error for custom validation markup', function () {
    $html = Blade::render('<x-bladex-components::text size="sm" variant="error">Invalid.</x-bladex-components::text>');

    expect($html)->toContain('text-red-600')->toContain('Invalid.');
});
