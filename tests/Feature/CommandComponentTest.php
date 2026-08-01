<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a command root with input, list, empty, and items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::command placeholder="Search…">
            <x-stencil::command.item value="calendar">Calendar</x-stencil::command.item>
        </x-stencil::command>
    BLADE);

    expect($html)
        ->toContain('data-command')
        ->toContain('data-command-input')
        ->toContain('role="combobox"')
        ->toContain('aria-autocomplete="list"')
        ->toContain('data-command-list')
        ->toContain('role="listbox"')
        ->toContain('data-command-empty')
        ->toContain('data-command-item')
        ->toContain('data-value="calendar"')
        ->toContain('role="option"')
        ->toContain('placeholder="Search…"')
        ->toContain('Calendar');
});

it('renders full compound structure without duplicating the input', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::command :shortcut="false">
            <x-stencil::command.input placeholder="Type a command…" />
            <x-stencil::command.list>
                <x-stencil::command.empty>Nothing here</x-stencil::command.empty>
                <x-stencil::command.item value="settings">Settings</x-stencil::command.item>
            </x-stencil::command.list>
        </x-stencil::command>
    BLADE);

    expect($html)
        ->toContain('data-command-input')
        ->toContain('Type a command…')
        ->toContain('Nothing here')
        ->toContain('Settings');

    expect(preg_match_all('/\sdata-command-input(?:\s|=|>)/', $html))->toBe(1);
    expect(preg_match_all('/\sdata-command-list(?:\s|=|>)/', $html))->toBe(1);
});

it('renders groups, separators, and keyboard shortcuts', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::command :shortcut="false">
            <x-stencil::command.input />
            <x-stencil::command.list>
                <x-stencil::command.group heading="Suggestions">
                    <x-stencil::command.item value="calendar" kbd="⌘C">Calendar</x-stencil::command.item>
                </x-stencil::command.group>
                <x-stencil::command.separator />
                <x-stencil::command.group heading="Settings">
                    <x-stencil::command.item value="profile" kbd="⌘P">Profile</x-stencil::command.item>
                </x-stencil::command.group>
            </x-stencil::command.list>
        </x-stencil::command>
    BLADE);

    expect($html)
        ->toContain('data-command-group')
        ->toContain('data-command-group-heading')
        ->toContain('Suggestions')
        ->toContain('Settings')
        ->toContain('data-command-separator')
        ->toContain('data-command-shortcut-hint')
        ->toContain('⌘C')
        ->toContain('⌘P');
});

it('renders command dialog with palette semantics and shortcut attribute', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::command.dialog name="palette" shortcut="meta.k" title="Run a command">
            <x-stencil::command>
                <x-stencil::command.item value="docs">Documentation</x-stencil::command.item>
            </x-stencil::command>
        </x-stencil::command.dialog>
    BLADE);

    expect($html)
        ->toContain('data-command-dialog')
        ->toContain('data-dialog-content')
        ->toContain('data-dialog-name="palette"')
        ->toContain('data-command-shortcut="meta.k"')
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"')
        ->toContain('sr-only')
        ->toContain('Run a command')
        ->toContain('data-command')
        ->toContain('Documentation');
});

it('normalizes cmd shortcut aliases to meta', function () {
    $html = Blade::render('<x-stencil::command.dialog name="go" shortcut="cmd.k">Hi</x-stencil::command.dialog>');

    expect($html)->toContain('data-command-shortcut="meta.k"');
});

it('marks disabled items and supports link items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::command>
            <x-stencil::command.item value="off" disabled>Disabled</x-stencil::command.item>
            <x-stencil::command.item value="docs" href="/docs">Docs</x-stencil::command.item>
        </x-stencil::command>
    BLADE);

    expect($html)
        ->toContain('data-disabled="true"')
        ->toContain('aria-disabled="true"')
        ->toContain('href="/docs"')
        ->toContain('<a');
});

it('ships a command.js script with filtering and keyboard helpers', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/command.js');

    expect($source)
        ->toContain('export function initCommands')
        ->toContain('data-command')
        ->toContain('ArrowDown')
        ->toContain('stencil:command:select')
        ->toContain('data-command-shortcut');
});
