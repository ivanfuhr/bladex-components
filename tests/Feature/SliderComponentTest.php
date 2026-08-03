<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders a slider root with hidden input and accessible thumb', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" :value="40" />
    BLADE);

    expect($html)
        ->toContain('data-slider')
        ->toContain('data-slider-hidden-input')
        ->toContain('name="volume"')
        ->toContain('value="40"')
        ->toContain('role="slider"')
        ->toContain('aria-valuemin="0"')
        ->toContain('aria-valuemax="100"')
        ->toContain('aria-valuenow="40"')
        ->toContain('aria-valuetext="40"')
        ->toContain('data-slider-min="0"')
        ->toContain('data-slider-max="100"')
        ->toContain('data-slider-step="1"')
        ->toContain('data-slider-range="false"')
        ->toContain('data-slider-track')
        ->toContain('data-slider-range')
        ->toContain('data-slider-thumb');

    expect(preg_match_all('/\sdata-slider-thumb(?:\s|=|>)/', $html))->toBe(1);
});

it('supports min max step and size', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="level" :min="10" :max="50" :step="5" :value="25" size="sm" />
    BLADE);

    expect($html)
        ->toContain('data-slider-min="10"')
        ->toContain('data-slider-max="50"')
        ->toContain('data-slider-step="5"')
        ->toContain('value="25"')
        ->toContain('aria-valuenow="25"')
        ->toContain('h-8')
        ->toContain('size-3.5');
});

it('renders dual thumbs for range values', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="price" :value="[20, 80]" />
    BLADE);

    expect($html)
        ->toContain('data-slider-range="true"')
        ->toContain('name="price[0]"')
        ->toContain('name="price[1]"')
        ->toContain('value="20"')
        ->toContain('value="80"')
        ->toContain('aria-valuenow="20"')
        ->toContain('aria-valuenow="80"')
        ->toContain('Minimum')
        ->toContain('Maximum');

    expect(preg_match_all('/\sdata-slider-thumb(?:\s|=|>)/', $html))->toBe(2);
});

it('enables range mode with the range prop', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="span" :range="true" :min="0" :max="100" />
    BLADE);

    expect($html)
        ->toContain('data-slider-range="true"')
        ->toContain('name="span[0]"')
        ->toContain('name="span[1]"')
        ->toContain('value="0"')
        ->toContain('value="100"');

    expect(preg_match_all('/\sdata-slider-thumb(?:\s|=|>)/', $html))->toBe(2);
});

it('marks the control invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" :invalid="true" />
    BLADE);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('data-invalid="true"');
});

it('disables thumbs when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" :disabled="true" />
    BLADE);

    expect($html)
        ->toContain('aria-disabled="true"')
        ->toContain('data-disabled="true"')
        ->toContain('tabindex="-1"');
});

it('inherits field invalid state from the Field shell', function () {
    $bag = new MessageBag(['volume' => ['The volume field is required.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="volume">
            <x-ui::slider name="volume" />
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"');
});

it('renders full compound structure without shortcut', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" :value="30" :shortcut="false">
            <x-ui::slider.track>
                <x-ui::slider.range />
            </x-ui::slider.track>
            <x-ui::slider.thumb :index="0" :value="30" />
        </x-ui::slider>
    BLADE);

    expect($html)
        ->toContain('data-slider-track')
        ->toContain('data-slider-range')
        ->toContain('data-slider-thumb')
        ->toContain('aria-valuenow="30"')
        ->toContain('name="volume"');
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" />
    BLADE);

    expect($html)->toContain('slider relative flex w-full touch-none select-none items-center h-9 w-full');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" class="w-auto" />
    BLADE);

    expect($html)->toContain('slider relative flex w-full touch-none select-none items-center h-9 w-auto');
});

it('wires the control id onto the first thumb', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" slider-id="volume-control" :value="[10, 90]" />
    BLADE);

    expect($html)
        ->toContain('id="volume-control"')
        ->toContain('id="volume-control-1"')
        ->toContain('data-slider-id="volume-control"');
});

it('clamps the initial value within min and max', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::slider name="volume" :min="0" :max="100" :value="150" />
    BLADE);

    expect($html)
        ->toContain('value="100"')
        ->toContain('aria-valuenow="100"');
});
