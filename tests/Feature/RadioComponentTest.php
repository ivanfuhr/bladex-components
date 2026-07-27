<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders radio group and items with a shared name', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::radio.group name="plan" legend="Plan">
            <x-stencil::radio value="free">Free</x-stencil::radio>
            <x-stencil::radio value="pro" :checked="true">Pro</x-stencil::radio>
        </x-stencil::radio.group>
    BLADE);

    expect($html)
        ->toContain('data-radio-group')
        ->toContain('name="plan"')
        ->toContain('value="free"')
        ->toContain('value="pro"')
        ->toContain('checked')
        ->toContain('Free')
        ->toContain('Pro');
});
