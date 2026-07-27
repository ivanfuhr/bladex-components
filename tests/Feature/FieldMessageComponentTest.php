<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders field error messages with alert role and error colors', function () {
    $html = Blade::render('<x-bladex-components::field.message variant="error">Too short.</x-bladex-components::field.message>');

    expect($html)
        ->toContain('data-field-message')
        ->toContain('field__message')
        ->toContain('data-field-message-variant="error"')
        ->toContain('role="alert"')
        ->toContain('text-red-600')
        ->toContain('dark:text-red-400')
        ->toContain('Too short.');
});

it('treats the invalid prop as an error variant', function () {
    $html = Blade::render('<x-bladex-components::field.message :invalid="true">Required.</x-bladex-components::field.message>');

    expect($html)
        ->toContain('data-field-message-variant="error"')
        ->toContain('text-red-600');
});

it('renders validation errors through the field errors helper', function () {
    $bag = new Illuminate\Support\MessageBag([
        'title' => ['The title field must be at least 3 characters.'],
    ]);
    $errors = new Illuminate\Support\ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render('<x-bladex-components::field.errors name="title" />');

    expect($html)
        ->toContain('data-field-message-variant="error"')
        ->toContain('text-red-600')
        ->toContain('at least 3 characters');
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
