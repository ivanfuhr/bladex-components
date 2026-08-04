<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders semantic heading tags with automatic font role', function (): void {
    $html = Blade::render('<x-ui::heading :level="3">Title</x-ui::heading>');

    expect($html)
        ->toContain('<h3')
        ->toContain('data-heading')
        ->toContain('Title')
        ->toContain('font-[family-name:var(--font-sans)]');
});

it('uses configured default heading level and pairs with default text size', function (): void {
    $heading = Blade::render('<x-ui::heading>Title</x-ui::heading>');
    $text = Blade::render('<x-ui::text>Body</x-ui::text>');

    expect($heading)
        ->toContain('<h2')
        ->toContain('text-lg')
        ->and($text)->toContain('text-base');
});

it('maps heading levels to the standardized size scale', function (int $level, string $sizeClass): void {
    $html = Blade::render('<x-ui::heading :level="'.$level.'">H</x-ui::heading>');

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
    $html = Blade::render('<x-ui::heading variant="subtle">Muted</x-ui::heading>');

    expect($html)
        ->toContain('text-zinc-500')
        ->not->toContain('text-zinc-950');
});
