<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a tooltip with trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::tooltip side="bottom">
            <x-stencil::tooltip.trigger>
                <x-stencil::button variant="outline">Hover</x-stencil::button>
            </x-stencil::tooltip.trigger>
            <x-stencil::tooltip.content>Add to library</x-stencil::tooltip.content>
        </x-stencil::tooltip>
    BLADE);

    expect($html)
        ->toContain('data-tooltip')
        ->toContain('data-side="bottom"')
        ->toContain('data-tooltip-trigger')
        ->toContain('role="tooltip"')
        ->toContain('w-max')
        ->toContain('whitespace-nowrap')
        ->toContain('Add to library')
        ->toContain('Hover');
});
