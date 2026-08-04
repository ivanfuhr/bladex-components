<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a popover with trigger and dialog content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::popover align="end" side="bottom">
            <x-ui::popover.trigger>
                <x-ui::button variant="outline">Open</x-ui::button>
            </x-ui::popover.trigger>
            <x-ui::popover.content>
                <p>Panel body</p>
            </x-ui::popover.content>
        </x-ui::popover>
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
        <x-ui::popover>
            <x-ui::popover.trigger>
                <button type="button">Open</button>
            </x-ui::popover.trigger>
            <x-ui::popover.content :open="true">
                Visible
            </x-ui::popover.content>
        </x-ui::popover>
    BLADE);

    expect($html)
        ->toContain('data-state="open"')
        ->toContain('Visible');
});

it('popover script tears down document listeners with createBindSignal', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/popover.js');

    expect($source)
        ->toContain('createBindSignal')
        ->toContain('{ signal }')
        ->toContain('stencil:mount')
        ->toContain('ensureAriaLabelledBy');
});
