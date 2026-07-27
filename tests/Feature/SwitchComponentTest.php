<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders switch with role switch', function () {
    $html = Blade::render('<x-stencil::switch name="notifications" :checked="true" />');

    expect($html)
        ->toContain('data-switch')
        ->toContain('role="switch"')
        ->toContain('name="notifications"')
        ->toContain('checked');
});

it('marks switch invalid when invalid prop is true', function () {
    $html = Blade::render('<x-stencil::switch name="notifications" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});
