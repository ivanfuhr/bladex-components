<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders an accordion with compound item trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::accordion exclusive>
            <x-stencil::accordion.item value="shipping" :expanded="true">
                <x-stencil::accordion.trigger>Shipping options</x-stencil::accordion.trigger>
                <x-stencil::accordion.content>Standard and express.</x-stencil::accordion.content>
            </x-stencil::accordion.item>
        </x-stencil::accordion>
    BLADE);

    expect($html)
        ->toContain('data-accordion')
        ->toContain('data-accordion-exclusive="true"')
        ->toContain('data-accordion-item')
        ->toContain('data-accordion-value="shipping"')
        ->toContain('data-accordion-trigger')
        ->toContain('data-accordion-content')
        ->toContain('aria-expanded="true"')
        ->toContain('role="region"')
        ->toContain('Shipping options')
        ->toContain('Standard and express.');
});

it('supports flux-style heading shorthand and disabled items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::accordion>
            <x-stencil::accordion.item heading="Refund policy" disabled>
                30-day money-back guarantee.
            </x-stencil::accordion.item>
        </x-stencil::accordion>
    BLADE);

    expect($html)
        ->toContain('Refund policy')
        ->toContain('30-day money-back guarantee.')
        ->toContain('data-accordion-disabled="true"')
        ->toContain('disabled');
});

it('wires aria-controls between trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::accordion>
            <x-stencil::accordion.item value="a" trigger-id="acc-trigger-a" content-id="acc-content-a">
                <x-stencil::accordion.trigger>Title</x-stencil::accordion.trigger>
                <x-stencil::accordion.content>Body</x-stencil::accordion.content>
            </x-stencil::accordion.item>
        </x-stencil::accordion>
    BLADE);

    expect($html)
        ->toContain('id="acc-trigger-a"')
        ->toContain('id="acc-content-a"')
        ->toContain('aria-controls="acc-content-a"')
        ->toContain('aria-labelledby="acc-trigger-a"');
});

it('marks multiple mode when exclusive is false', function () {
    $html = Blade::render('<x-stencil::accordion :multiple="true" transition variant="reverse" bordered />');

    expect($html)
        ->toContain('data-accordion-exclusive="false"')
        ->toContain('data-accordion-transition="true"')
        ->toContain('data-accordion-variant="reverse"')
        ->toContain('rounded-xl');
});

it('hides closed transition panels from the accessibility tree', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::accordion transition>
            <x-stencil::accordion.item value="a">
                <x-stencil::accordion.trigger>Title</x-stencil::accordion.trigger>
                <x-stencil::accordion.content>Body</x-stencil::accordion.content>
            </x-stencil::accordion.item>
        </x-stencil::accordion>
    BLADE);

    expect($html)
        ->toContain('data-accordion-transition="true"')
        ->toContain('aria-hidden="true"')
        ->toContain('inert');
});
