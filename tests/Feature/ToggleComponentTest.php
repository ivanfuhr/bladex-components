<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a toggle with aria-pressed', function () {
    $html = Blade::render('<x-ui::toggle :pressed="true">Bold</x-ui::toggle>');

    expect($html)
        ->toContain('data-toggle')
        ->toContain('aria-pressed="true"')
        ->toContain('data-state="on"')
        ->toContain('type="button"')
        ->toContain('Bold');
});

it('renders outline and size variants', function () {
    $html = Blade::render('<x-ui::toggle variant="outline" size="sm">Italic</x-ui::toggle>');

    expect($html)
        ->toContain('data-variant="outline"')
        ->toContain('data-size="sm"')
        ->toContain('border-zinc-200')
        ->toContain('h-8')
        ->toContain('aria-pressed="false"');
});

it('forwards disabled state', function () {
    $html = Blade::render('<x-ui::toggle disabled>Off</x-ui::toggle>');

    expect($html)->toContain('disabled');
});
