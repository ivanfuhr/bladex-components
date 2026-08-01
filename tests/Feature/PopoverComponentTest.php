<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a popover with trigger and dialog content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::popover align="end" side="bottom">
            <x-stencil::popover.trigger>
                <x-stencil::button variant="outline">Open</x-stencil::button>
            </x-stencil::popover.trigger>
            <x-stencil::popover.content>
                <p>Panel body</p>
            </x-stencil::popover.content>
        </x-stencil::popover>
    BLADE);

    expect($html)
        ->toContain('data-popover')
        ->toContain('data-align="end"')
        ->toContain('data-side="bottom"')
        ->toContain('data-popover-trigger')
        ->toContain('data-popover-content')
        ->toContain('role="dialog"')
        ->toContain('data-state="closed"')
        ->toContain('Panel body');
});

it('can render popover content initially open', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::popover>
            <x-stencil::popover.trigger>
                <button type="button">Open</button>
            </x-stencil::popover.trigger>
            <x-stencil::popover.content :open="true">
                Visible
            </x-stencil::popover.content>
        </x-stencil::popover>
    BLADE);

    expect($html)
        ->toContain('data-state="open"')
        ->toContain('Visible');
});
