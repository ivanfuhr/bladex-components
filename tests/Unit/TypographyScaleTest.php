<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;
use Ivanfuhr\Stencil\Support\Typography\TypographyScale;

it('resolves the four standardized size tokens', function (): void {
    $scale = app(TypographyScale::class);

    expect($scale->classes('sm'))->toBe('text-sm leading-5')
        ->and($scale->classes('default'))->toBe('text-base leading-6')
        ->and($scale->classes('lg'))->toBe('text-lg leading-7')
        ->and($scale->classes('xl'))->toBe('text-xl leading-8')
        ->and($scale->classes(null))->toBe('text-base leading-6');
});

it('rejects unknown size tokens', function (): void {
    app(TypographyScale::class)->classes('huge');
})->throws(InvalidArgumentException::class);

it('merges partial scale overrides from project config', function (): void {
    $configPath = app(ProjectConfig::class)->path();

    file_put_contents($configPath, json_encode([
        'registry' => 'package://registry.json',
        'paths' => ['ui' => 'resources/views/ui'],
        'typography' => [
            'scale' => [
                'sm' => ['text' => 'text-xs', 'leading' => 'leading-4'],
            ],
        ],
    ], JSON_THROW_ON_ERROR)."\n");

    $this->app->forgetInstance(TypographyConfig::class);
    $this->app->forgetInstance(TypographyScale::class);

    expect(app(TypographyScale::class)->classes('sm'))->toBe('text-xs leading-4')
        ->and(app(TypographyScale::class)->classes('lg'))->toBe('text-lg leading-7');

    @unlink($configPath);
});

it('only exposes the four scale keys from config', function (): void {
    $keys = array_keys(app(TypographyConfig::class)->scale());

    expect($keys)->toBe(['sm', 'default', 'lg', 'xl']);
});
