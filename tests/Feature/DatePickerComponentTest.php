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

it('renders shortcut panel parts for presets, inputs, and confirmation', function (): void {
    $html = Blade::render(
        '<x-stencil::date-picker name="range_at" mode="range" with-presets with-inputs with-confirmation />',
    );

    expect($html)
        ->toContain('data-date-picker-presets')
        ->toContain('data-date-picker-manual-inputs')
        ->toContain('data-date-picker-confirm')
        ->toContain('data-date-picker-cancel')
        ->toContain('data-date-picker-with-confirmation');
});

it('renders full compound structure without shortcut', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::date-picker name="published_at" value="2026-07-29" :shortcut="false">
            <x-stencil::date-picker.button />
            <x-stencil::date-picker.panel>
                <x-stencil::date-picker.manual-inputs />
                <x-stencil::calendar value="2026-07-29" />
                <x-stencil::date-picker.footer />
            </x-stencil::date-picker.panel>
        </x-stencil::date-picker>
    BLADE);

    expect($html)
        ->toContain('data-date-picker-trigger')
        ->toContain('data-date-picker-panel')
        ->toContain('data-date-picker-manual-inputs')
        ->toContain('data-date-picker-confirm')
        ->toContain('data-calendar')
        ->toContain('name="published_at"');
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
        ->toContain('data-datetime-picker-panel')
        ->toContain('data-datetime-picker-time-list')
        ->toContain('data-datetime-picker-confirm');
});

it('renders full datetime picker compound structure without shortcut', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" :shortcut="false">
            <x-stencil::date-picker.button data-datetime-picker-trigger />
            <x-stencil::datetime-picker.panel>
                <x-stencil::calendar value="2026-07-29" data-datetime-picker-calendar />
                <x-stencil::datetime-picker.time-list />
                <x-stencil::datetime-picker.footer />
            </x-stencil::datetime-picker.panel>
        </x-stencil::datetime-picker>
    BLADE);

    expect($html)
        ->toContain('data-datetime-picker-trigger')
        ->toContain('data-datetime-picker-panel')
        ->toContain('data-datetime-picker-calendar')
        ->toContain('data-datetime-picker-time-list')
        ->toContain('data-datetime-picker-confirm')
        ->toContain('name="scheduled_at"');
});
