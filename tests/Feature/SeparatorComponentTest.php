<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a horizontal decorative separator by default', function () {
    $html = Blade::render('<x-stencil::separator />');

    expect($html)
        ->toContain('data-separator')
        ->toContain('data-orientation="horizontal"')
        ->toContain('role="none"')
        ->toContain('h-px');
});

it('renders a semantic vertical separator', function () {
    $html = Blade::render('<x-stencil::separator orientation="vertical" :decorative="false" />');

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('role="separator"')
        ->toContain('aria-orientation="vertical"')
        ->toContain('w-px');
});
