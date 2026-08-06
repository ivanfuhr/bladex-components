<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a button group with role group', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::button-group aria-label="Actions">
            <x-std::button variant="outline">One</x-std::button>
            <x-std::button variant="outline">Two</x-std::button>
        </x-std::button-group>
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
        <x-std::button-group orientation="vertical">
            <x-std::button>Up</x-std::button>
            <x-std::button>Down</x-std::button>
        </x-std::button-group>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('flex-col');
});

it('renders separator and text affixes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::button-group>
            <x-std::button-group.text>https://</x-std::button-group.text>
            <x-std::button variant="outline">Copy</x-std::button>
            <x-std::button-group.separator />
            <x-std::button variant="outline">Paste</x-std::button>
        </x-std::button-group>
    BLADE);

    expect($html)
        ->toContain('data-button-group-text')
        ->toContain('https://')
        ->toContain('data-button-group-separator')
        ->toContain('data-orientation="vertical"')
        ->toContain('Copy')
        ->toContain('Paste');
});
