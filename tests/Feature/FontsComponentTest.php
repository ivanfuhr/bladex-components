<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders google font assets and css variables', function (): void {
    $html = Blade::render('<x-std::fonts />');

    expect($html)
        ->toContain('rel="preconnect"')
        ->toContain('fonts.googleapis.com')
        ->toContain('fonts.gstatic.com')
        ->toContain('family=Inter:wght@400;500;600;700')
        ->toContain('--font-sans:');
});

it('renders nothing when no fonts are configured', function (): void {
    config(['std-components.typography.fonts' => []]);

    $html = Blade::render('<x-std::fonts />');

    expect(trim($html))->toBe('');
});
