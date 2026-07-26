<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Support\Button\ButtonClassMap;

it('maps shadcn destructive and default variants to package names', function (): void {
    $map = app(ButtonClassMap::class);

    expect($map->normalizeVariant('destructive'))->toBe('danger')
        ->and($map->normalizeVariant('default'))->toBe('primary')
        ->and($map->normalizeVariant('outline'))->toBe('outline');
});

it('builds primary button classes with optional accent color', function (): void {
    $map = app(ButtonClassMap::class);

    expect($map->classes('primary'))
        ->toContain('bg-zinc-900')
        ->and($map->classes('primary', color: 'blue'))
        ->toContain('bg-blue-600')
        ->toContain('hover:bg-blue-700');
});

it('sizes icon-only buttons as squares', function (): void {
    $map = app(ButtonClassMap::class);

    expect($map->classes(options: ['iconOnly' => true]))
        ->toContain('size-9')
        ->and($map->classes('outline', 'sm', options: ['iconOnly' => true]))
        ->toContain('size-8');
});

it('exposes a tailwind content probe with primary utilities', function (): void {
    $map = app(ButtonClassMap::class);

    expect($map->tailwindContentProbe())
        ->toContain('bg-zinc-900')
        ->toContain('text-zinc-50')
        ->toContain('ring-white/15');
});
