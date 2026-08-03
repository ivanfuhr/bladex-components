<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a native checkbox control', function () {
    $html = Blade::render('<x-ui::checkbox name="terms" value="1" :checked="true" />');

    expect($html)
        ->toContain('data-checkbox')
        ->toContain('type="checkbox"')
        ->toContain('name="terms"')
        ->toContain('checked');
});

it('marks checkbox invalid when invalid prop is true', function () {
    $html = Blade::render('<x-ui::checkbox name="terms" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});
