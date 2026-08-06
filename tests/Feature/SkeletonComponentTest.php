<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a pulsing skeleton placeholder', function () {
    $html = Blade::render('<x-std::skeleton class="h-4 w-32" />');

    expect($html)
        ->toContain('data-skeleton')
        ->toContain('animate-pulse')
        ->toContain('aria-hidden="true"')
        ->toContain('h-4')
        ->toContain('w-32');
});

it('supports circular skeletons', function () {
    $html = Blade::render('<x-std::skeleton rounded="full" class="size-10" />');

    expect($html)->toContain('rounded-full')->toContain('size-10');
});
