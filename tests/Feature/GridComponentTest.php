<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\StdComponents\Support\Grid\GridClassMap;

it('renders a default grid with container query root', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::grid>
            <div>One</div>
        </x-std::grid>
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
    $html = Blade::render('<x-std::grid md="3" class="max-w-3xl" />');

    expect($html)
        ->toContain('class="@container max-w-3xl"')
        ->toContain('class="grid grid-cols-1 @md:grid-cols-3 gap-4"');
});

it('renders container breakpoint column utilities from scalar props', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::grid md="3" sm="2" gap="5">
            <div>Cell</div>
        </x-std::grid>
    BLADE);

    expect($html)
        ->toContain('@sm:grid-cols-2')
        ->toContain('@md:grid-cols-3')
        ->toContain('gap-5');
});

it('renders viewport breakpoint column utilities when container is disabled', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::grid md="3" :container="false" />
    BLADE);

    expect($html)
        ->toContain('data-container="false"')
        ->not->toContain('@container')
        ->toContain('md:grid-cols-3')
        ->not->toContain('@md:grid-cols-3');
});

it('renders a fixed column count', function () {
    $html = Blade::render('<x-std::grid :cols="3" />');

    expect($html)->toContain('grid-cols-3');
});

it('renders grid item span utilities', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::grid sm="2">
            <x-std::grid.item span="full">Full</x-std::grid.item>
            <x-std::grid.item :span="2">Half</x-std::grid.item>
            <x-std::grid.item :span="1" md="full">Responsive</x-std::grid.item>
        </x-std::grid>
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
        <x-std::grid sm="2" :container="false">
            <x-std::grid.item md="full">Full</x-std::grid.item>
        </x-std::grid>
    BLADE);

    expect($html)
        ->toContain('md:col-span-full')
        ->not->toContain('@md:col-span-full');
});

it('merges caller classes onto the grid root', function () {
    $html = Blade::render('<x-std::grid class="max-w-3xl" md="3" />');

    expect($html)->toContain('max-w-3xl');
});

it('exposes grid layout utilities for tailwind scanning', function () {
    expect(GridClassMap::SCAN_CLASSES)
        ->toContain('@md:grid-cols-3')
        ->toContain('@md:col-span-full')
        ->toContain('md:grid-cols-3');
});
