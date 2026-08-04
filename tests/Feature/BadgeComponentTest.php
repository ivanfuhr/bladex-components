<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders badge variants and sizes', function () {
    $html = Blade::render('<x-ui::badge variant="destructive" size="lg" rounded>New</x-ui::badge>');

    expect($html)
        ->toContain('data-badge')
        ->toContain('data-variant="destructive"')
        ->toContain('bg-red-600')
        ->toContain('rounded-full')
        ->toContain('text-sm')
        ->toContain('New');
});

it('renders color badges and outline variant', function () {
    $solid = Blade::render('<x-ui::badge color="lime">Beta</x-ui::badge>');
    $outline = Blade::render('<x-ui::badge variant="outline">Draft</x-ui::badge>');

    expect($solid)->toContain('bg-lime-100')->toContain('Beta');
    expect($outline)->toContain('border')->toContain('Draft');
});

it('renders removable badge close control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::badge>
            Admin
            <x-ui::badge.close />
        </x-ui::badge>
    BLADE);

    expect($html)
        ->toContain('Admin')
        ->toContain('data-badge-close')
        ->toContain('aria-label');
});

it('renders as span when as anchor is requested without href', function () {
    $html = Blade::render('<x-ui::badge as="a">Draft</x-ui::badge>');

    expect($html)
        ->toContain('<span')
        ->toContain('Draft')
        ->not->toContain('href=');
});
