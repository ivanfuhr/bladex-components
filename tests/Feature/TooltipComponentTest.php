<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a tooltip with trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::tooltip side="bottom">
            <x-ui::tooltip.trigger>
                <x-ui::button variant="outline">Hover</x-ui::button>
            </x-ui::tooltip.trigger>
            <x-ui::tooltip.content>Add to library</x-ui::tooltip.content>
        </x-ui::tooltip>
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
