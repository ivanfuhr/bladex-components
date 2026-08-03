<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders field root with orientation markers', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::field orientation="inline" name="email">
            <x-ui::field.label>Email</x-ui::field.label>
        </x-ui::field>
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
        <x-ui::field name="email">
            <x-ui::input name="email" />
            <x-ui::field.errors name="email" />
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"')
        ->toContain('Invalid email.');
});

it('renders field description using the message primitive', function () {
    $html = Blade::render('<x-ui::field.description>Helper copy.</x-ui::field.description>');

    expect($html)
        ->toContain('data-field-message')
        ->toContain('Helper copy.');
});

it('associates field labels with nested controls via control id', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="email">
            <x-ui::field.label>Email</x-ui::field.label>
            <x-ui::input name="email" type="email" />
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('for="email"')
        ->toContain('id="email"');
});

it('associates checkbox labels so clicking the label toggles the control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="terms" orientation="inline">
            <x-ui::checkbox name="terms" />
            <x-ui::field.label>Accept terms</x-ui::field.label>
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('for="terms"')
        ->toContain('id="terms"')
        ->toContain('type="checkbox"');
});

it('respects an explicit control-id over the field name', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="email" control-id="signup-email">
            <x-ui::field.label>Email</x-ui::field.label>
            <x-ui::input name="email" type="email" />
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('for="signup-email"')
        ->toContain('id="signup-email"');
});

it('renders wildcard field errors for indexed validation keys', function () {
    $bag = new MessageBag([
        'members.0.name' => ['Name is required.'],
        'members.1.name' => ['Name is required.'],
    ]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render('<x-ui::field.errors name="members.*.name" />');

    expect($html)
        ->toContain('Name is required.')
        ->toContain('data-field-message');
});
