<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dialog with trigger, content, and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::dialog>
            <x-ui::dialog.trigger>Open</x-ui::dialog.trigger>
            <x-ui::dialog.content>
                <x-ui::dialog.header>
                    <x-ui::dialog.title>Title</x-ui::dialog.title>
                    <x-ui::dialog.description>Description</x-ui::dialog.description>
                </x-ui::dialog.header>
            </x-ui::dialog.content>
        </x-ui::dialog>
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
    $tailwind = (string) file_get_contents(dirname(__DIR__, 2).'/resources/tailwind/stencil.css');
    $package = (string) file_get_contents(dirname(__DIR__, 2).'/resources/css/stencil.css');
    $workbench = (string) file_get_contents(dirname(__DIR__, 2).'/workbench/resources/css/stencil.css');

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
        <x-ui::dialog.content>
            <x-ui::dialog.title>Confirm</x-ui::dialog.title>
            <x-ui::dialog.description>This cannot be undone.</x-ui::dialog.description>
        </x-ui::dialog.content>
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
        <x-ui::dialog.content>
            <x-ui::dialog.title>Confirm</x-ui::dialog.title>
        </x-ui::dialog.content>
    BLADE);

    expect($html)
        ->toContain('aria-labelledby="')
        ->not->toContain('aria-describedby');
});

it('renders alert dialog semantics and small size', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::dialog.content name="delete" size="sm" :alert="true" :closable="false">
            <x-ui::dialog.title>Delete project?</x-ui::dialog.title>
        </x-ui::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="delete"')
        ->toContain('role="alertdialog"')
        ->toContain('max-w-sm')
        ->not->toContain('data-dialog-close');
});

it('renders named triggers for flux-style composition', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::dialog.trigger name="confirm">Delete</x-ui::dialog.trigger>
        <x-ui::dialog.content name="confirm">Body</x-ui::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="confirm"')
        ->toContain('data-dialog-trigger');
});

it('marks dialog as non-dismissible when configured', function () {
    $html = Blade::render('<x-ui::dialog.content :dismissible="false">Locked</x-ui::dialog.content>');

    expect($html)->toContain('data-dialog-dismissible="false"');
});

it('renders flyout dialog positioning classes', function () {
    $html = Blade::render('<x-ui::dialog.content flyout flyout-position="left">Panel</x-ui::dialog.content>');

    expect($html)
        ->toContain('data-dialog-flyout="true"')
        ->toContain('left-0');
});

it('centers preview panels without fixed positioning offsets', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::dialog.content preview>
            <x-ui::dialog.title>Preview</x-ui::dialog.title>
        </x-ui::dialog.content>
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
    $html = Blade::render('<x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>');

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
