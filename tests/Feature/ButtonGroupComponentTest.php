<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a button group with role group', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::button-group aria-label="Actions">
            <x-stencil::button variant="outline">One</x-stencil::button>
            <x-stencil::button variant="outline">Two</x-stencil::button>
        </x-stencil::button-group>
    BLADE);

    expect($html)
        ->toContain('data-button-group')
        ->toContain('role="group"')
        ->toContain('aria-label="Actions"')
        ->toContain('data-orientation="horizontal"')
        ->toContain('One')
        ->toContain('Two');
});

it('supports vertical orientation', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::button-group orientation="vertical">
            <x-stencil::button>Up</x-stencil::button>
            <x-stencil::button>Down</x-stencil::button>
        </x-stencil::button-group>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('flex-col');
});

it('renders separator and text affixes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::button-group>
            <x-stencil::button-group.text>https://</x-stencil::button-group.text>
            <x-stencil::button variant="outline">Copy</x-stencil::button>
            <x-stencil::button-group.separator />
            <x-stencil::button variant="outline">Paste</x-stencil::button>
        </x-stencil::button-group>
    BLADE);

    expect($html)
        ->toContain('data-button-group-text')
        ->toContain('https://')
        ->toContain('data-button-group-separator')
        ->toContain('data-orientation="vertical"')
        ->toContain('Copy')
        ->toContain('Paste');
});
