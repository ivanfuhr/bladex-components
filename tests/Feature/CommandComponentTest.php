<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a command root with input, list, empty, and items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::command placeholder="Search…">
            <x-std::command.item value="calendar">Calendar</x-std::command.item>
        </x-std::command>
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
        <x-std::command :shortcut="false">
            <x-std::command.input placeholder="Type a command…" />
            <x-std::command.list>
                <x-std::command.empty>Nothing here</x-std::command.empty>
                <x-std::command.item value="settings">Settings</x-std::command.item>
            </x-std::command.list>
        </x-std::command>
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
        <x-std::command :shortcut="false">
            <x-std::command.input />
            <x-std::command.list>
                <x-std::command.group heading="Suggestions">
                    <x-std::command.item value="calendar" kbd="⌘C">Calendar</x-std::command.item>
                </x-std::command.group>
                <x-std::command.separator />
                <x-std::command.group heading="Settings">
                    <x-std::command.item value="profile" kbd="⌘P">Profile</x-std::command.item>
                </x-std::command.group>
            </x-std::command.list>
        </x-std::command>
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
        <x-std::command.dialog name="palette" shortcut="meta.k" title="Run a command">
            <x-std::command>
                <x-std::command.item value="docs">Documentation</x-std::command.item>
            </x-std::command>
        </x-std::command.dialog>
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
    $html = Blade::render('<x-std::command.dialog name="go" shortcut="cmd.k">Hi</x-std::command.dialog>');

    expect($html)->toContain('data-command-shortcut="meta.k"');
});

it('marks disabled items and supports link items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::command>
            <x-std::command.item value="off" disabled>Disabled</x-std::command.item>
            <x-std::command.item value="docs" href="/docs">Docs</x-std::command.item>
        </x-std::command>
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
        ->toContain('std:command:select')
        ->toContain('data-command-shortcut');
});
