<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\Stencil\Support\Icon\IconVariant;
use Ivanfuhr\Stencil\Support\Icon\LucideIconStubGenerator;

it('normalizes lucide icon variants', function (): void {
    expect(IconVariant::normalize('solid'))->toBe('outline')
        ->and(IconVariant::classString('mini'))->toBe('block shrink-0 size-5')
        ->and(IconVariant::pixelSize('outline'))->toBe(16)
        ->and(IconVariant::strokeWidth('micro'))->toBe('2.5')
        ->and(IconVariant::strokeWidth('outline'))->toBe('2');
});

it('generates a lucide icon blade stub', function (): void {
    $svg = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
SVG;

    $stub = (new LucideIconStubGenerator)->generate('search', $svg);

    expect($stub)
        ->toContain('@props([')
        ->toContain('<x-stencil::icon.lucide')
        ->toContain('<circle cx="11" cy="11" r="8"/>')
        ->not->toContain('width="24"');
});

it('lets explicit size classes override the lucide variant box', function (): void {
    seedStencilTestIcons(['upload']);

    $html = Blade::render('<x-stencil::icon name="upload" class="size-6 text-zinc-600" />');

    expect($html)
        ->toContain('block shrink-0')
        ->toContain('size-6')
        ->toContain('text-zinc-600')
        ->toContain('data-icon')
        ->not->toContain('size-4')
        ->not->toContain('width="16"')
        ->not->toContain('height="16"');
});
