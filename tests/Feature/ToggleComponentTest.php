<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a toggle with aria-pressed', function () {
    $html = Blade::render('<x-std::toggle :pressed="true">Bold</x-std::toggle>');

    expect($html)
        ->toContain('data-toggle')
        ->toContain('aria-pressed="true"')
        ->toContain('data-state="on"')
        ->toContain('type="button"')
        ->toContain('Bold');
});

it('renders outline and size variants', function () {
    $html = Blade::render('<x-std::toggle variant="outline" size="sm">Italic</x-std::toggle>');

    expect($html)
        ->toContain('data-variant="outline"')
        ->toContain('data-size="sm"')
        ->toContain('border-zinc-200')
        ->toContain('h-10')
        ->toContain('aria-pressed="false"');
});

it('forwards disabled state', function () {
    $html = Blade::render('<x-std::toggle disabled>Off</x-std::toggle>');

    expect($html)->toContain('disabled');
});
