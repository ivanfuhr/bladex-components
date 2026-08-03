<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;

it('falls back heading role to sans when display font is missing', function (): void {
    $roles = app(TypographyConfig::class)->roles();

    expect($roles['body'])->toBe('sans')
        ->and($roles['heading'])->toBe('sans');
});

it('reads typography roles from package config', function (): void {
    config([
        'stencil.typography' => [
            'fonts' => [
                'sans' => [
                    'provider' => 'google',
                    'family' => 'DM Sans',
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
            'roles' => [
                'body' => 'sans',
                'heading' => 'display',
            ],
        ],
    ]);

    $roles = app(TypographyConfig::class)->roles();

    expect($roles)->toBe(['body' => 'sans', 'heading' => 'display']);
});

it('builds css font variables from configured families', function (): void {
    $variables = app(TypographyConfig::class)->cssFontVariables();

    expect($variables)->toHaveKey('sans')
        ->and($variables['sans'])->toContain('Inter');
});

it('exposes default text size and heading level', function (): void {
    $config = app(TypographyConfig::class);

    expect($config->defaultTextSize())->toBe('default')
        ->and($config->defaultHeadingLevel())->toBe(2);
});
