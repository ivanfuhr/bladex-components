<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dialog with trigger, content, and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog>
            <x-std::dialog.trigger>Open</x-std::dialog.trigger>
            <x-std::dialog.content>
                <x-std::dialog.header>
                    <x-std::dialog.title>Title</x-std::dialog.title>
                    <x-std::dialog.description>Description</x-std::dialog.description>
                </x-std::dialog.header>
            </x-std::dialog.content>
        </x-std::dialog>
    BLADE);

    expect($html)
        ->toContain('data-dialog')
        ->toContain('data-dialog-trigger')
        ->toContain('data-dialog-content')
        ->toContain('data-dialog-panel')
        ->toContain('data-dialog-title')
        ->toContain('data-dialog-description')
        ->toContain('<dialog')
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"')
        ->toContain('Title')
        ->toContain('Description')
        ->toContain('open:opacity-100')
        ->toContain('opacity-0');
});

it('keeps dialog open-visibility CSS wired for Tailwind scanners', function () {
    $tailwind = (string) file_get_contents(dirname(__DIR__, 2).'/resources/tailwind/std-components.css');
    $package = (string) file_get_contents(dirname(__DIR__, 2).'/resources/css/std-components.css');
    $workbench = (string) file_get_contents(dirname(__DIR__, 2).'/workbench/resources/css/std-components.css');

    foreach ([$tailwind, $package] as $css) {
        expect($css)
            ->toContain('@layer theme, base, components, utilities;')
            ->toContain('src/View/Components/Dialog/Content.php')
            ->toContain('src/View/Components/Command/Dialog.php')
            ->toContain('@source inline("open:opacity-100 open:motion-safe:scale-100")')
            ->toContain('.dialog__content:is(:open, [open])')
            ->toContain('opacity: 1')
            ->not->toContain('src/View/Components/**/*.php');
    }

    expect($workbench)
        ->toContain('src/View/Components/Dialog/Content.php')
        ->toContain('src/View/Components/Command/Dialog.php')
        ->not->toContain('src/View/Components/**/*.php');
});

it('wires matching title and description ids for aria labelling', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog.content>
            <x-std::dialog.title>Confirm</x-std::dialog.title>
            <x-std::dialog.description>This cannot be undone.</x-std::dialog.description>
        </x-std::dialog.content>
    BLADE);

    expect($html)->toMatch('/aria-labelledby="([^"]+)"/');
    preg_match('/aria-labelledby="([^"]+)"/', $html, $labelledBy);
    preg_match('/aria-describedby="([^"]+)"/', $html, $describedBy);

    expect($labelledBy[1])->not->toBeEmpty();
    expect($describedBy[1])->not->toBeEmpty();

    expect($html)
        ->toContain('id="'.$labelledBy[1].'"')
        ->toContain('id="'.$describedBy[1].'"')
        ->toContain('data-dialog-title="'.$labelledBy[1].'"')
        ->toContain('data-dialog-description="'.$describedBy[1].'"');
});

it('omits aria-describedby when no description is present', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog.content>
            <x-std::dialog.title>Confirm</x-std::dialog.title>
        </x-std::dialog.content>
    BLADE);

    expect($html)
        ->toContain('aria-labelledby="')
        ->not->toContain('aria-describedby');
});

it('renders alert dialog semantics and small size', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog.content name="delete" size="sm" :alert="true" :closable="false">
            <x-std::dialog.title>Delete project?</x-std::dialog.title>
        </x-std::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="delete"')
        ->toContain('role="alertdialog"')
        ->toContain('max-w-sm')
        ->not->toContain('data-dialog-close');
});

it('renders named triggers for flux-style composition', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog.trigger name="confirm">Delete</x-std::dialog.trigger>
        <x-std::dialog.content name="confirm">Body</x-std::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="confirm"')
        ->toContain('data-dialog-trigger');
});

it('marks dialog as non-dismissible when configured', function () {
    $html = Blade::render('<x-std::dialog.content :dismissible="false">Locked</x-std::dialog.content>');

    expect($html)->toContain('data-dialog-dismissible="false"');
});

it('renders flyout dialog positioning classes', function () {
    $html = Blade::render('<x-std::dialog.content flyout flyout-position="left">Panel</x-std::dialog.content>');

    expect($html)
        ->toContain('data-dialog-flyout="true"')
        ->toContain('left-0');
});

it('centers preview panels without fixed positioning offsets', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::dialog.content preview>
            <x-std::dialog.title>Preview</x-std::dialog.title>
        </x-std::dialog.content>
    BLADE);

    expect($html)
        ->toContain('dialog__preview')
        ->toContain('data-dialog-preview')
        ->toContain('items-center')
        ->toContain('justify-center')
        ->toContain('max-w-lg')
        ->not->toContain('left-1/2')
        ->not->toContain('-translate-x-1/2')
        ->not->toContain('top-1/2')
        ->not->toContain('fixed');
});

it('renders dialog cancel helper with close behavior', function () {
    $html = Blade::render('<x-std::dialog.cancel>Cancel</x-std::dialog.cancel>');

    expect($html)
        ->toContain('data-dialog-close')
        ->toContain('data-dialog-cancel')
        ->toContain('Cancel');
});

it('alert dialog script prefers cancel for initial focus', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dialog.js');

    expect($source)
        ->toContain("dialog.getAttribute('role') === 'alertdialog'")
        ->toContain("dialog.querySelector('[data-dialog-cancel]')")
        ->toContain('button:not([data-dialog-close]):not([disabled])');
});

it('dialog script tracks trigger binds with WeakSet instead of DOM markers', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/dialog.js');

    expect($source)
        ->toContain('const boundTriggers = new WeakSet()')
        ->toContain('boundTriggers.has(trigger)')
        ->toContain('boundTriggers.add(trigger)')
        ->not->toContain('dialogTriggerBound')
        ->not->toContain('data-dialog-trigger-bound');
});
