<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders date picker with hidden input and panel', function (): void {
    $html = Blade::render('<x-ui::date-picker name="published_at" value="2026-07-29" />');

    expect($html)
        ->toContain('data-date-picker')
        ->toContain('name="published_at"')
        ->toContain('value="2026-07-29"')
        ->toContain('data-date-picker-panel')
        ->toContain('id="published_at-panel"')
        ->toContain('aria-controls="published_at-panel"')
        ->toContain('data-calendar');
});

it('renders range date picker value', function (): void {
    $html = Blade::render('<x-ui::date-picker mode="range" value="2026-07-01/2026-07-15" />');

    expect($html)
        ->toContain('data-date-picker-mode="range"')
        ->toContain('value="2026-07-01/2026-07-15"');
});

it('renders shortcut panel parts for presets, inputs, and confirmation', function (): void {
    $html = Blade::render(
        '<x-ui::date-picker name="range_at" mode="range" with-presets with-inputs with-confirmation />',
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
        <x-ui::date-picker name="published_at" value="2026-07-29" :shortcut="false">
            <x-ui::date-picker.button />
            <x-ui::date-picker.panel>
                <x-ui::date-picker.manual-inputs />
                <x-ui::calendar value="2026-07-29" />
                <x-ui::date-picker.footer />
            </x-ui::date-picker.panel>
        </x-ui::date-picker>
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
    $html = Blade::render('<x-ui::time-picker name="starts_at" value="09:30" />');

    expect($html)
        ->toContain('data-time-picker')
        ->toContain('name="starts_at"')
        ->toContain('value="09:30"')
        ->toContain('role="listbox"')
        ->toContain('aria-haspopup="listbox"')
        ->toContain('aria-controls="starts_at-listbox"')
        ->toContain('id="starts_at-listbox"')
        ->toContain('aria-label="Select time"')
        ->toContain('data-time-picker-panel')
        ->toContain('hidden');

    expect($html)->not->toMatch('/data-time-picker-panel[^>]*\bclass="[^"]*\bhidden\b/');
});

it('applies disabled to the time picker trigger button', function (): void {
    $html = Blade::render('<x-ui::time-picker name="starts_at" disabled />');

    expect($html)
        ->toContain('data-time-picker-trigger')
        ->toContain('disabled');
});

it('renders datetime picker hidden iso value', function (): void {
    $html = Blade::render(
        '<x-ui::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />',
    );

    expect($html)
        ->toContain('data-datetime-picker')
        ->toContain('name="scheduled_at"')
        ->toContain('data-datetime-picker-panel')
        ->toContain('id="scheduled_at-panel"')
        ->toContain('aria-controls="scheduled_at-panel"')
        ->toContain('id="scheduled_at-time-list"')
        ->toContain('aria-label="Select time"')
        ->toContain('data-datetime-picker-time-list')
        ->toContain('data-datetime-picker-confirm')
        ->toContain('role="listbox"');
});

it('renders full datetime picker compound structure without shortcut', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" :shortcut="false">
            <x-ui::date-picker.button data-datetime-picker-trigger />
            <x-ui::datetime-picker.panel>
                <x-ui::calendar value="2026-07-29" data-datetime-picker-calendar />
                <x-ui::datetime-picker.time-list />
                <x-ui::datetime-picker.footer />
            </x-ui::datetime-picker.panel>
        </x-ui::datetime-picker>
    BLADE);

    expect($html)
        ->toContain('data-datetime-picker-trigger')
        ->toContain('data-datetime-picker-panel')
        ->toContain('data-datetime-picker-calendar')
        ->toContain('data-datetime-picker-time-list')
        ->toContain('data-datetime-picker-confirm')
        ->toContain('name="scheduled_at"');
});

it('calendar script follows APG keyboard and dark-aware month titles', function (): void {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/calendar.js');

    expect($source)
        ->toContain("event.key === 'Home'")
        ->toContain("event.key === 'End'")
        ->toContain("event.key === 'PageUp'")
        ->toContain("event.key === 'PageDown'")
        ->toContain('dark:text-zinc-50')
        ->toContain('btn.tabIndex')
        ->toContain('max-w-[17.5rem]')
        ->not->toContain('rgb(24 24 27)');
});

it('time picker script restores focus on escape and exposes listbox keyboard', function (): void {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/time-picker.js');

    expect($source)
        ->toContain("role', 'listbox'")
        ->toContain("case 'Home':")
        ->toContain("case 'End':")
        ->toContain("case 'Escape':")
        ->toContain('trigger.focus()')
        ->toContain('restorePanelFromPortal')
        ->toContain('[data-time-picker-panel][data-stencil-portaled]')
        ->toContain("panel.closest('[data-time-picker]')");
});

it('datetime picker script focuses calendar on open and restores trigger on escape', function (): void {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/datetime-picker.js');

    expect($source)
        ->toContain('calendarEl.focus()')
        ->toContain('trigger.focus()')
        ->toContain("role', 'listbox'")
        ->toContain("case 'Home':")
        ->toContain("case 'End':");
});

it('renders calendar range mode and selectable header markers', function (): void {
    $html = Blade::render(
        '<x-ui::calendar mode="range" value="2026-07-01/2026-07-15" selectable-header with-today week-numbers />',
    );

    expect($html)
        ->toContain('data-calendar')
        ->toContain('data-calendar-mode="range"');
});

it('renders time picker with seconds and disabled unavailable slots wiring', function (): void {
    $html = Blade::render(
        '<x-ui::time-picker name="ends_at" value="09:30:00" with-seconds :step="15" clearable />',
    );

    expect($html)
        ->toContain('data-time-picker')
        ->toContain('name="ends_at"')
        ->toContain('value="09:30:00"');
});

it('renders datetime picker disabled and clearable states', function (): void {
    $html = Blade::render(
        '<x-ui::datetime-picker name="due_at" disabled clearable with-seconds />',
    );

    expect($html)
        ->toContain('data-datetime-picker')
        ->toContain('name="due_at"')
        ->toContain('disabled');
});

it('renders date picker disabled, clearable, min/max, and locale wiring', function (): void {
    $html = Blade::render(
        '<x-ui::date-picker name="published_at" disabled clearable min="2026-01-01" max="2026-12-31" locale="pt_BR" />',
    );

    expect($html)
        ->toContain('data-date-picker')
        ->toContain('disabled')
        ->toContain('data-date-picker-clear')
        ->toContain('data-calendar-min="2026-01-01"')
        ->toContain('data-calendar-max="2026-12-31"')
        ->toContain('data-date-picker-locale="pt_BR"')
        ->toContain('data-calendar-locale="pt_BR"');
});

it('renders calendar min, max, locale, and size attributes', function (): void {
    $html = Blade::render(
        '<x-ui::calendar min="2026-01-01" max="2026-12-31" locale="pt_BR" size="sm" open-to="2026-06-01" />',
    );

    expect($html)
        ->toContain('data-calendar-min="2026-01-01"')
        ->toContain('data-calendar-max="2026-12-31"')
        ->toContain('data-calendar-locale="pt_BR"')
        ->toContain('data-calendar-open-to="2026-06-01"')
        ->toContain('size-9');
});

it('wires datetime picker timeStep onto the root for the script', function (): void {
    $html = Blade::render(
        '<x-ui::datetime-picker name="scheduled_at" :time-step="15" />',
    );

    expect($html)
        ->toContain('data-datetime-picker')
        ->toContain('data-datetime-picker-step="15"');
});
