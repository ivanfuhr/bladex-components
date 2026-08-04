<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\Stencil\Support\Grid\GridClassMap;

it('renders a default grid with container query root', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::grid>
            <div>One</div>
        </x-ui::grid>
    BLADE);

    expect($html)
        ->toContain('data-grid')
        ->toContain('data-container="true"')
        ->toContain('grid')
        ->toContain('@container')
        ->toContain('grid-cols-1')
        ->toContain('gap-4')
        ->toContain('One')
        ->not->toMatch('/class="[^"]*@container[^"]*@md:/');
});

it('wraps the track grid so container queries respond to the wrapper width', function () {
    $html = Blade::render('<x-ui::grid md="3" class="max-w-3xl" />');

    expect($html)
        ->toContain('class="@container max-w-3xl"')
        ->toContain('class="grid grid-cols-1 @md:grid-cols-3 gap-4"');
});

it('renders container breakpoint column utilities from scalar props', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::grid md="3" sm="2" gap="5">
            <div>Cell</div>
        </x-ui::grid>
    BLADE);

    expect($html)
        ->toContain('@sm:grid-cols-2')
        ->toContain('@md:grid-cols-3')
        ->toContain('gap-5');
});

it('renders viewport breakpoint column utilities when container is disabled', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::grid md="3" :container="false" />
    BLADE);

    expect($html)
        ->toContain('data-container="false"')
        ->not->toContain('@container')
        ->toContain('md:grid-cols-3')
        ->not->toContain('@md:grid-cols-3');
});

it('renders a fixed column count', function () {
    $html = Blade::render('<x-ui::grid :cols="3" />');

    expect($html)->toContain('grid-cols-3');
});

it('renders grid item span utilities', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::grid sm="2">
            <x-ui::grid.item span="full">Full</x-ui::grid.item>
            <x-ui::grid.item :span="2">Half</x-ui::grid.item>
            <x-ui::grid.item :span="1" md="full">Responsive</x-ui::grid.item>
        </x-ui::grid>
    BLADE);

    expect($html)
        ->toContain('data-grid-item')
        ->toContain('col-span-full')
        ->toContain('col-span-2')
        ->toContain('@md:col-span-full')
        ->toContain('Full')
        ->toContain('Responsive');
});

it('renders viewport span utilities when the parent grid disables container queries', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::grid sm="2" :container="false">
            <x-ui::grid.item md="full">Full</x-ui::grid.item>
        </x-ui::grid>
    BLADE);

    expect($html)
        ->toContain('md:col-span-full')
        ->not->toContain('@md:col-span-full');
});

it('merges caller classes onto the grid root', function () {
    $html = Blade::render('<x-ui::grid class="max-w-3xl" md="3" />');

    expect($html)->toContain('max-w-3xl');
});

it('exposes grid layout utilities for tailwind scanning', function () {
    expect(GridClassMap::SCAN_CLASSES)
        ->toContain('@md:grid-cols-3')
        ->toContain('@md:col-span-full')
        ->toContain('md:grid-cols-3');
});
