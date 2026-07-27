<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\Stencil\Support\Typography\GoogleFontsStylesheetBuilder;
use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;

it('renders google font assets and css variables', function (): void {
    $html = Blade::render('<x-stencil::fonts />');

    expect($html)
        ->toContain('rel="preconnect"')
        ->toContain('fonts.googleapis.com')
        ->toContain('fonts.gstatic.com')
        ->toContain('family=Inter:wght@400;500;600;700')
        ->toContain('--font-sans:');
});

it('renders nothing when no fonts are configured', function (): void {
    config(['stencil.typography.fonts' => []]);

    $this->app->forgetInstance(TypographyConfig::class);
    $this->app->forgetInstance(GoogleFontsStylesheetBuilder::class);

    $html = Blade::render('<x-stencil::fonts />');

    expect(trim($html))->toBe('');
});
