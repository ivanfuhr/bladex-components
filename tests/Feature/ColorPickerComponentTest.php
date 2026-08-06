<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;

it('renders a color picker with trigger, popover, and swatches', function () {
    $html = Blade::render('<x-std::color-picker name="brand_color" value="#3366cc" />');

    expect($html)
        ->toContain('data-color-picker')
        ->toContain('data-color-picker-swatch-trigger')
        ->toContain('data-color-picker-popover')
        ->toContain('data-color-picker-area')
        ->toContain('data-color-picker-hue')
        ->toContain('data-color-picker-swatches')
        ->toContain('data-color-picker-hex')
        ->toContain('name="brand_color"')
        ->toContain('value="#3366cc"')
        ->toContain('#3366CC');
});

it('can hide swatches and enable the dropper', function () {
    $html = Blade::render('<x-std::color-picker name="brand_color" :swatches="false" :dropper="true" />');

    expect($html)
        ->not->toContain('data-color-picker-swatches')
        ->toContain('data-color-picker-dropper');
});

it('renders full compound structure without shortcut', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::color-picker name="brand_color" value="#3366cc" :shortcut="false">
            <x-std::color-picker.trigger current-value="#3366cc" popover-id="test-popover">
                <x-std::color-picker.hex current-value="#3366cc" popover-id="test-popover" />
            </x-std::color-picker.trigger>
            <x-std::color-picker.content popover-id="test-popover">
                <x-std::color-picker.area />
                <x-std::color-picker.hue />
                <x-std::color-picker.swatches :swatch-palette="[['#ef4444', '#ef4444']]" />
            </x-std::color-picker.content>
        </x-std::color-picker>
    BLADE);

    expect($html)
        ->toContain('data-color-picker-trigger')
        ->toContain('data-color-picker-popover')
        ->toContain('data-color-picker-area')
        ->toContain('data-color-picker-hue')
        ->toContain('data-color-picker-swatches')
        ->toContain('data-color-picker-hex')
        ->toContain('name="brand_color"');
});

it('requires a name attribute', function () {
    Blade::render('<x-std::color-picker />');
})->throws(ViewException::class);

it('color picker script removes orphaned portaled popovers on remount', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/color-picker.js');

    expect($source)
        ->toContain('[data-color-picker-popover][data-color-picker-portaled]')
        ->toContain("popover.closest('[data-color-picker]')")
        ->toContain('popover.remove()')
        ->toContain('createBindSignal')
        ->toContain('std:mount');
});
