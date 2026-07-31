<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders field root with orientation markers', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::field orientation="inline" name="email">
            <x-stencil::field.label>Email</x-stencil::field.label>
        </x-stencil::field>
    BLADE);

    expect($html)
        ->toContain('data-field')
        ->toContain('data-field-orientation="inline"');
});

it('marks field invalid when the error bag has messages for the name', function () {
    $bag = new MessageBag(['email' => ['Invalid email.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-stencil::field name="email">
            <x-stencil::input name="email" />
            <x-stencil::field.errors name="email" />
        </x-stencil::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"')
        ->toContain('Invalid email.');
});

it('renders field description using the message primitive', function () {
    $html = Blade::render('<x-stencil::field.description>Helper copy.</x-stencil::field.description>');

    expect($html)
        ->toContain('data-field-message')
        ->toContain('Helper copy.');
});

it('renders wildcard field errors for indexed validation keys', function () {
    $bag = new MessageBag([
        'members.0.name' => ['Name is required.'],
        'members.1.name' => ['Name is required.'],
    ]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render('<x-stencil::field.errors name="members.*.name" />');

    expect($html)
        ->toContain('Name is required.')
        ->toContain('data-field-message');
});
