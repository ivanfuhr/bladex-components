<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a closed collapsible with trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::collapsible>
            <x-stencil::collapsible.trigger>Toggle details</x-stencil::collapsible.trigger>
            <x-stencil::collapsible.content>Hidden by default.</x-stencil::collapsible.content>
        </x-stencil::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-collapsible')
        ->toContain('data-state="closed"')
        ->toContain('data-collapsible-trigger')
        ->toContain('data-collapsible-content')
        ->toContain('aria-expanded="false"')
        ->toContain('Toggle details')
        ->toContain('Hidden by default.')
        ->toContain('hidden');
});

it('renders an open collapsible and disabled state', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::collapsible :open="true" disabled transition>
            <x-stencil::collapsible.trigger>Open panel</x-stencil::collapsible.trigger>
            <x-stencil::collapsible.content>Visible content.</x-stencil::collapsible.content>
        </x-stencil::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-state="open"')
        ->toContain('data-collapsible-disabled="true"')
        ->toContain('data-collapsible-transition="true"')
        ->toContain('aria-expanded="true"')
        ->toContain('disabled')
        ->toContain('Visible content.');
});

it('supports as-child trigger wrapping', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::collapsible>
            <x-stencil::collapsible.trigger as-child>
                <x-stencil::button variant="outline">More</x-stencil::button>
            </x-stencil::collapsible.trigger>
            <x-stencil::collapsible.content>Details</x-stencil::collapsible.content>
        </x-stencil::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-trigger')
        ->toContain('contents')
        ->toContain('More')
        ->toContain('Details');
});
