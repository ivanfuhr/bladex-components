<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a tooltip with trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::tooltip side="bottom">
            <x-std::tooltip.trigger>
                <x-std::button variant="outline">Hover</x-std::button>
            </x-std::tooltip.trigger>
            <x-std::tooltip.content>Add to library</x-std::tooltip.content>
        </x-std::tooltip>
    BLADE);

    expect($html)
        ->toContain('data-tooltip')
        ->toContain('data-side="bottom"')
        ->toContain('data-tooltip-trigger')
        ->toContain('role="tooltip"')
        ->toContain('aria-hidden="true"')
        ->toContain('w-max')
        ->toContain('whitespace-nowrap')
        ->toContain('Add to library')
        ->toContain('Hover');
});
