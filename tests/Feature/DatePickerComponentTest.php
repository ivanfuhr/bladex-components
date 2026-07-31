<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders date picker with hidden input and panel', function (): void {
    $html = Blade::render('<x-stencil::date-picker name="published_at" value="2026-07-29" />');

    expect($html)
        ->toContain('data-date-picker')
        ->toContain('name="published_at"')
        ->toContain('value="2026-07-29"')
        ->toContain('data-date-picker-panel')
        ->toContain('data-calendar');
});

it('renders range date picker value', function (): void {
    $html = Blade::render('<x-stencil::date-picker mode="range" value="2026-07-01/2026-07-15" />');

    expect($html)
        ->toContain('data-date-picker-mode="range"')
        ->toContain('value="2026-07-01/2026-07-15"');
});

it('renders time picker with hidden input', function (): void {
    $html = Blade::render('<x-stencil::time-picker name="starts_at" value="09:30" />');

    expect($html)
        ->toContain('data-time-picker')
        ->toContain('name="starts_at"')
        ->toContain('value="09:30"');
});

it('renders datetime picker hidden iso value', function (): void {
    $html = Blade::render(
        '<x-stencil::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />',
    );

    expect($html)
        ->toContain('data-datetime-picker')
        ->toContain('name="scheduled_at"')
        ->toContain('data-datetime-picker-panel');
});
