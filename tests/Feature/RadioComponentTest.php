<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders radio group and items with a shared name', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::radio.group name="plan" legend="Plan">
            <x-ui::radio value="free">Free</x-ui::radio>
            <x-ui::radio value="pro" :checked="true">Pro</x-ui::radio>
        </x-ui::radio.group>
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
