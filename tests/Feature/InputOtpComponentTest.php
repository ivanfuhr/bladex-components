<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders an otp root with hidden input and labeled slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" />
    BLADE);

    expect($html)
        ->toContain('data-input-otp')
        ->toContain('data-input-otp-hidden-input')
        ->toContain('name="code"')
        ->toContain('data-input-otp-slot')
        ->toContain('data-input-otp-length="6"')
        ->toContain('data-input-otp-mode="numeric"')
        ->toContain('Digit 1 of 6')
        ->toContain('autocomplete="one-time-code"')
        ->toContain('inputmode="numeric"');

    expect(preg_match_all('/\sdata-input-otp-slot(?:\s|=|>)/', $html))->toBe(6);
});

it('supports configurable length and alphanumeric mode', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="token" :length="4" mode="alphanumeric" :separated="false" />
    BLADE);

    expect($html)
        ->toContain('data-input-otp-length="4"')
        ->toContain('data-input-otp-mode="alphanumeric"')
        ->toContain('inputmode="text"')
        ->not->toContain('data-input-otp-separator');

    expect(preg_match_all('/\sdata-input-otp-slot(?:\s|=|>)/', $html))->toBe(4);
});

it('renders a separator by default for even lengths', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" />
    BLADE);

    expect($html)
        ->toContain('data-input-otp-separator')
        ->toContain('data-input-otp-group');
});

it('seeds slots from the value prop', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" value="123456" />
    BLADE);

    expect($html)
        ->toContain('value="123456"')
        ->toContain('data-complete="true"')
        ->toContain('value="1"')
        ->toContain('value="6"');
});

it('marks the control invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" :invalid="true" />
    BLADE);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('data-invalid="true"');
});

it('disables slots when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" :disabled="true" />
    BLADE);

    expect($html)
        ->toContain('disabled')
        ->toContain('data-disabled="true"');
});

it('inherits field invalid state from the Field shell', function () {
    $bag = new MessageBag(['code' => ['The code field is required.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-stencil::field name="code">
            <x-stencil::input-otp name="code" />
        </x-stencil::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"');
});

it('renders full compound structure without shortcut', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" :length="4" :shortcut="false">
            <x-stencil::input-otp.group>
                <x-stencil::input-otp.slot :index="0" />
                <x-stencil::input-otp.slot :index="1" />
            </x-stencil::input-otp.group>
            <x-stencil::input-otp.separator />
            <x-stencil::input-otp.group>
                <x-stencil::input-otp.slot :index="2" />
                <x-stencil::input-otp.slot :index="3" />
            </x-stencil::input-otp.group>
        </x-stencil::input-otp>
    BLADE);

    expect($html)
        ->toContain('data-input-otp-group')
        ->toContain('data-input-otp-separator')
        ->toContain('data-index="0"')
        ->toContain('data-index="3"');

    expect(preg_match_all('/\sdata-input-otp-slot(?:\s|=|>)/', $html))->toBe(4);
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" />
    BLADE);

    expect($html)->toContain('input-otp flex min-w-0 items-center gap-2 w-full');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" class="w-auto" />
    BLADE);

    expect($html)->toContain('input-otp flex min-w-0 items-center gap-2 w-auto');
});

it('wires the control id onto the first slot', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input-otp name="code" input-otp-id="verify-code" />
    BLADE);

    expect($html)
        ->toContain('id="verify-code"')
        ->toContain('id="verify-code-1"')
        ->toContain('data-input-otp-id="verify-code"');
});
