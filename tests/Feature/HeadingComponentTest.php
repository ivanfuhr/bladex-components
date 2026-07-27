<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders semantic heading tags with automatic font role', function (): void {
    $html = Blade::render('<x-stencil::heading :level="3">Title</x-stencil::heading>');

    expect($html)
        ->toContain('<h3')
        ->toContain('data-heading')
        ->toContain('Title')
        ->toContain('font-[family-name:var(--font-sans)]');
});

it('uses configured default heading level and pairs with default text size', function (): void {
    $heading = Blade::render('<x-stencil::heading>Title</x-stencil::heading>');
    $text = Blade::render('<x-stencil::text>Body</x-stencil::text>');

    expect($heading)
        ->toContain('<h2')
        ->toContain('text-lg')
        ->and($text)->toContain('text-base');
});

it('maps heading levels to the standardized size scale', function (int $level, string $sizeClass): void {
    $html = Blade::render('<x-stencil::heading :level="'.$level.'">H</x-stencil::heading>');

    expect($html)->toContain($sizeClass);
})->with([
    [1, 'text-xl'],
    [2, 'text-lg'],
    [3, 'text-base'],
    [4, 'text-sm'],
    [5, 'text-sm'],
    [6, 'text-sm'],
]);

it('applies subtle variant classes', function (): void {
    $html = Blade::render('<x-stencil::heading variant="subtle">Muted</x-stencil::heading>');

    expect($html)->toContain('text-zinc-500');
});
