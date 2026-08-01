<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders badge variants and sizes', function () {
    $html = Blade::render('<x-stencil::badge variant="destructive" size="lg" rounded>New</x-stencil::badge>');

    expect($html)
        ->toContain('data-badge')
        ->toContain('data-variant="destructive"')
        ->toContain('bg-red-600')
        ->toContain('rounded-full')
        ->toContain('text-sm')
        ->toContain('New');
});

it('renders color badges and outline variant', function () {
    $solid = Blade::render('<x-stencil::badge color="lime">Beta</x-stencil::badge>');
    $outline = Blade::render('<x-stencil::badge variant="outline">Draft</x-stencil::badge>');

    expect($solid)->toContain('bg-lime-100')->toContain('Beta');
    expect($outline)->toContain('border')->toContain('Draft');
});

it('renders removable badge close control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::badge>
            Admin
            <x-stencil::badge.close />
        </x-stencil::badge>
    BLADE);

    expect($html)
        ->toContain('Admin')
        ->toContain('data-badge-close')
        ->toContain('aria-label');
});
