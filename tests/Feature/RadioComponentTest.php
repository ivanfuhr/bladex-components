<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders radio group and items with a shared name', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::radio.group name="plan" legend="Plan">
            <x-std::radio value="free">Free</x-std::radio>
            <x-std::radio value="pro" :checked="true">Pro</x-std::radio>
        </x-std::radio.group>
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
