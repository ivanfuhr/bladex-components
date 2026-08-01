<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a single toggle group with radiogroup semantics', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::toggle-group type="single" variant="outline" default-value="bold" aria-label="Format">
            <x-stencil::toggle-group.item value="bold">Bold</x-stencil::toggle-group.item>
            <x-stencil::toggle-group.item value="italic">Italic</x-stencil::toggle-group.item>
        </x-stencil::toggle-group>
    BLADE);

    expect($html)
        ->toContain('data-toggle-group')
        ->toContain('role="radiogroup"')
        ->toContain('role="radio"')
        ->toContain('aria-checked="true"')
        ->toContain('data-state="on"')
        ->toContain('data-value="bold"')
        ->toContain('Bold')
        ->toContain('Italic');
});

it('renders a multiple toggle group with aria-pressed items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::toggle-group type="multiple" :default-value="['bold', 'italic']">
            <x-stencil::toggle-group.item value="bold">Bold</x-stencil::toggle-group.item>
            <x-stencil::toggle-group.item value="italic">Italic</x-stencil::toggle-group.item>
            <x-stencil::toggle-group.item value="underline">Underline</x-stencil::toggle-group.item>
        </x-stencil::toggle-group>
    BLADE);

    expect($html)
        ->toContain('role="group"')
        ->toContain('data-type="multiple"')
        ->toContain('aria-pressed="true"')
        ->toContain('Underline');
});

it('supports vertical orientation and spacing', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::toggle-group orientation="vertical" :spacing="2" variant="outline">
            <x-stencil::toggle-group.item value="a">A</x-stencil::toggle-group.item>
            <x-stencil::toggle-group.item value="b">B</x-stencil::toggle-group.item>
        </x-stencil::toggle-group>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('data-spacing="2"')
        ->toContain('flex-col')
        ->toContain('--toggle-gap');
});
