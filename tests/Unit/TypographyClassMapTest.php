<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Support\Typography\TypographyClassMap;
use Ivanfuhr\BladexComponents\Support\Typography\TypographyConfig;
use Ivanfuhr\BladexComponents\Support\Typography\TypographyScale;

it('steps through the scale for heading levels relative to defaults', function (): void {
    $map = app(TypographyClassMap::class);

    expect($map->headingSizeForLevel(1))->toBe('xl')
        ->and($map->headingSizeForLevel(2))->toBe('lg')
        ->and($map->headingSizeForLevel(3))->toBe('default')
        ->and($map->headingSizeForLevel(4))->toBe('sm')
        ->and($map->headingSizeForLevel(5))->toBe('sm')
        ->and($map->headingSizeForLevel(6))->toBe('sm');
});

it('pairs default heading level with one step above default text size', function (): void {
    $config = app(TypographyConfig::class);
    $scale = app(TypographyScale::class);
    $map = app(TypographyClassMap::class);

    $textSize = $config->defaultTextSize();
    $headingLevel = $config->defaultHeadingLevel();

    expect($map->headingSizeForLevel($headingLevel))->toBe($scale->stepUp($textSize))
        ->and($scale->classes($textSize))->toBe('text-base leading-6')
        ->and($scale->classes($map->headingSizeForLevel($headingLevel)))->toBe('text-lg leading-7');
});

it('recomputes heading sizes when default text size changes', function (): void {
    config(['bladex-components.typography.defaults.text_size' => 'lg']);

    $this->app->forgetInstance(TypographyConfig::class);
    $this->app->forgetInstance(TypographyScale::class);
    $this->app->forgetInstance(TypographyClassMap::class);

    $map = app(TypographyClassMap::class);

    expect($map->headingSizeForLevel(2))->toBe('xl')
        ->and($map->headingSizeForLevel(3))->toBe('lg');
});

it('applies typography scale classes to input controls', function (): void {
    $map = app(TypographyClassMap::class);

    expect($map->inputControlClasses(null))
        ->toContain('text-base')
        ->toContain('font-[family-name:var(--font-sans)]')
        ->and($map->inputControlClasses('sm'))->toContain('text-sm');
});
