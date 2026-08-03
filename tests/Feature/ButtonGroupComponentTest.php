<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a button group with role group', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::button-group aria-label="Actions">
            <x-ui::button variant="outline">One</x-ui::button>
            <x-ui::button variant="outline">Two</x-ui::button>
        </x-ui::button-group>
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
        <x-ui::button-group orientation="vertical">
            <x-ui::button>Up</x-ui::button>
            <x-ui::button>Down</x-ui::button>
        </x-ui::button-group>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('flex-col');
});

it('renders separator and text affixes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::button-group>
            <x-ui::button-group.text>https://</x-ui::button-group.text>
            <x-ui::button variant="outline">Copy</x-ui::button>
            <x-ui::button-group.separator />
            <x-ui::button variant="outline">Paste</x-ui::button>
        </x-ui::button-group>
    BLADE);

    expect($html)
        ->toContain('data-button-group-text')
        ->toContain('https://')
        ->toContain('data-button-group-separator')
        ->toContain('data-orientation="vertical"')
        ->toContain('Copy')
        ->toContain('Paste');
});
