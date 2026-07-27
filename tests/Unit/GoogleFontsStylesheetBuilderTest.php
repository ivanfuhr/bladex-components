<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Support\Typography\GoogleFontsStylesheetBuilder;
use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;

it('builds a google fonts stylesheet url for configured families', function (): void {
    $url = app(GoogleFontsStylesheetBuilder::class)->buildUrl();

    expect($url)
        ->toStartWith('https://fonts.googleapis.com/css2?')
        ->toContain('family=Inter:wght@400;500;600;700')
        ->toContain('display=swap');
});

it('returns null when no google fonts are configured', function (): void {
    config(['stencil.typography.fonts' => []]);

    $this->app->forgetInstance(GoogleFontsStylesheetBuilder::class);
    $this->app->forgetInstance(TypographyConfig::class);

    expect(app(GoogleFontsStylesheetBuilder::class)->buildUrl())->toBeNull();
});

it('combines multiple google families in one url', function (): void {
    config([
        'stencil.typography.fonts' => [
            'sans' => [
                'provider' => 'google',
                'family' => 'Inter',
                'weights' => [400, 700],
                'subsets' => ['latin'],
            ],
            'display' => [
                'provider' => 'google',
                'family' => 'Fraunces',
                'weights' => [600],
                'subsets' => ['latin'],
            ],
        ],
    ]);

    $this->app->forgetInstance(GoogleFontsStylesheetBuilder::class);
    $this->app->forgetInstance(TypographyConfig::class);

    $url = app(GoogleFontsStylesheetBuilder::class)->buildUrl();

    expect($url)
        ->toContain('family=Inter:wght@400;700')
        ->toContain('family=Fraunces:wght@600');
});
