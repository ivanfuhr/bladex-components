<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders paragraph text by default', function (): void {
    $html = Blade::render('<x-ui::text>Hello</x-ui::text>');

    expect($html)
        ->toContain('<p')
        ->toContain('data-text')
        ->toContain('Hello')
        ->toContain('text-base')
        ->toContain('font-[family-name:var(--font-sans)]');
});

it('renders inline span text when requested', function (): void {
    $html = Blade::render('<x-ui::text inline>Inline</x-ui::text>');

    expect($html)->toContain('<span')->toContain('Inline');
});

it('applies size variant and color props', function (): void {
    $html = Blade::render('<x-ui::text size="lg" variant="strong" color="blue">Copy</x-ui::text>');

    expect($html)
        ->toContain('text-lg')
        ->toContain('font-semibold')
        ->toContain('text-blue-600');
});

it('merges consumer classes on the root element', function (): void {
    $html = Blade::render('<x-ui::text class="mt-2">Copy</x-ui::text>');

    expect($html)->toContain('mt-2');
});
