<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders switch with role switch', function () {
    $html = Blade::render('<x-std::switch name="notifications" :checked="true" />');

    expect($html)
        ->toContain('data-switch')
        ->toContain('role="switch"')
        ->toContain('aria-checked="true"')
        ->toContain('name="notifications"')
        ->toContain('id="notifications"')
        ->toContain('checked')
        ->toContain('class="switch')
        ->toContain('h-9')
        ->toContain('shrink-0');
});

it('renders small switch with compact touch row height', function () {
    $html = Blade::render('<x-std::switch name="notifications" size="sm" />');

    expect($html)
        ->toContain('switch--sm')
        ->toContain('h-8');
});

it('marks switch invalid when invalid prop is true', function () {
    $html = Blade::render('<x-std::switch name="notifications" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});
