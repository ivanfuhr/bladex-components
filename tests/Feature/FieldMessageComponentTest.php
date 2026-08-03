<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders field error messages with alert role and error colors', function () {
    $html = Blade::render('<x-ui::field.message variant="error">Too short.</x-ui::field.message>');

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
    $html = Blade::render('<x-ui::field.message :invalid="true">Required.</x-ui::field.message>');

    expect($html)
        ->toContain('data-field-message-variant="error"')
        ->toContain('text-red-600');
});

it('renders validation errors through the field errors helper', function () {
    $bag = new MessageBag([
        'title' => ['The title field must be at least 3 characters.'],
    ]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render('<x-ui::field.errors name="title" />');

    expect($html)
        ->toContain('data-field-message-variant="error"')
        ->toContain('text-red-600')
        ->toContain('at least 3 characters');
});

it('renders hint messages without alert role', function () {
    $html = Blade::render('<x-ui::field.message>Optional hint.</x-ui::field.message>');

    expect($html)
        ->toContain('data-field-message-variant="hint"')
        ->not->toContain('role="alert"')
        ->toContain('text-zinc-500');
});

it('styles text variant error for custom validation markup', function () {
    $html = Blade::render('<x-ui::text size="sm" variant="error">Invalid.</x-ui::text>');

    expect($html)->toContain('text-red-600')->toContain('Invalid.');
});
