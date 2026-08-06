<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a popover with trigger and dialog content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::popover align="end" side="bottom">
            <x-std::popover.trigger>
                <x-std::button variant="outline">Open</x-std::button>
            </x-std::popover.trigger>
            <x-std::popover.content>
                <p>Panel body</p>
            </x-std::popover.content>
        </x-std::popover>
    BLADE);

    expect($html)
        ->toContain('data-popover')
        ->toContain('data-align="end"')
        ->toContain('data-side="bottom"')
        ->toContain('data-popover-trigger')
        ->toContain('data-popover-content')
        ->toContain('role="dialog"')
        ->toContain('aria-modal="false"')
        ->toContain('data-state="closed"')
        ->toContain('aria-hidden="true"')
        ->toContain('inert')
        ->toContain('Panel body');
});

it('can render popover content initially open', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::popover>
            <x-std::popover.trigger>
                <button type="button">Open</button>
            </x-std::popover.trigger>
            <x-std::popover.content :open="true">
                Visible
            </x-std::popover.content>
        </x-std::popover>
    BLADE);

    expect($html)
        ->toContain('data-state="open"')
        ->toContain('Visible');
});

it('popover script toggles inert and aria-hidden with open state', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/popover.js');

    expect($source)
        ->toContain("content.removeAttribute('inert')")
        ->toContain("content.removeAttribute('aria-hidden')")
        ->toContain("content.setAttribute('inert', '')")
        ->toContain("content.setAttribute('aria-hidden', 'true')");
});

it('popover script tears down document listeners with createBindSignal', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/popover.js');

    expect($source)
        ->toContain('createBindSignal')
        ->toContain('{ signal }')
        ->toContain('std:mount')
        ->toContain('ensureAriaLabelledBy')
        ->toContain('ensureContentPortaled')
        ->toContain('restoreContentFromPortal');
});
