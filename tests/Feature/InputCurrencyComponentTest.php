<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Number;

beforeEach(function () {
    if (! extension_loaded('intl')) {
        $this->markTestSkipped('The intl extension is required for Number::currency.');
    }
});

it('renders a currency input with hidden float value and formatted display', function () {
    $expectedDisplay = Number::currency(12.34, 'BRL', 'pt_BR', 2);

    $html = Blade::render(<<<'BLADE'
        <x-std::input.currency
            name="amount"
            :value="12.34"
            currency="BRL"
            locale="pt_BR"
            :precision="2"
        />
    BLADE);

    expect($html)
        ->toContain('data-input-currency')
        ->toContain('data-input-currency-mode="cents"')
        ->toContain('data-input-currency-locale="pt-BR"')
        ->toContain('data-input-currency-currency="BRL"')
        ->toContain('data-input-currency-precision="2"')
        ->toContain('data-input-currency-value')
        ->toContain('data-input-currency-display')
        ->toContain('name="amount"')
        ->toContain('value="12.34"')
        ->toContain($expectedDisplay);
});

it('does not put name on the visible control', function () {
    $html = Blade::render('<x-std::input.currency name="amount" :value="1" currency="USD" locale="en" :precision="2" />');

    preg_match_all('/<input[^>]*name="amount"[^>]*>/', $html, $matches);

    expect($matches[0])->toHaveCount(1);
    expect($html)->toContain('data-input-currency-display');
});

it('marks the visible control invalid when the invalid prop is true', function () {
    $html = Blade::render('<x-std::input.currency name="amount" :invalid="true" currency="USD" locale="en" :precision="2" />');

    expect($html)->toContain('aria-invalid="true"');
});

it('renders empty hidden value when value is not provided', function () {
    $html = Blade::render('<x-std::input.currency name="amount" currency="USD" locale="en" :precision="2" />');

    expect($html)
        ->toContain('data-input-currency-value')
        ->not->toMatch('/data-input-currency-value[^>]*\svalue="/');
});
