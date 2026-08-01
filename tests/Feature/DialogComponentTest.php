<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a dialog with trigger, content, and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dialog>
            <x-stencil::dialog.trigger>Open</x-stencil::dialog.trigger>
            <x-stencil::dialog.content>
                <x-stencil::dialog.header>
                    <x-stencil::dialog.title>Title</x-stencil::dialog.title>
                    <x-stencil::dialog.description>Description</x-stencil::dialog.description>
                </x-stencil::dialog.header>
            </x-stencil::dialog.content>
        </x-stencil::dialog>
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
        ->toContain('Description');
});

it('wires matching title and description ids for aria labelling', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dialog.content>
            <x-stencil::dialog.title>Confirm</x-stencil::dialog.title>
            <x-stencil::dialog.description>This cannot be undone.</x-stencil::dialog.description>
        </x-stencil::dialog.content>
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
        <x-stencil::dialog.content>
            <x-stencil::dialog.title>Confirm</x-stencil::dialog.title>
        </x-stencil::dialog.content>
    BLADE);

    expect($html)
        ->toContain('aria-labelledby="')
        ->not->toContain('aria-describedby');
});

it('renders alert dialog semantics and small size', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dialog.content name="delete" size="sm" :alert="true" :closable="false">
            <x-stencil::dialog.title>Delete project?</x-stencil::dialog.title>
        </x-stencil::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="delete"')
        ->toContain('role="alertdialog"')
        ->toContain('max-w-sm')
        ->not->toContain('data-dialog-close');
});

it('renders named triggers for flux-style composition', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dialog.trigger name="confirm">Delete</x-stencil::dialog.trigger>
        <x-stencil::dialog.content name="confirm">Body</x-stencil::dialog.content>
    BLADE);

    expect($html)
        ->toContain('data-dialog-name="confirm"')
        ->toContain('data-dialog-trigger');
});

it('marks dialog as non-dismissible when configured', function () {
    $html = Blade::render('<x-stencil::dialog.content :dismissible="false">Locked</x-stencil::dialog.content>');

    expect($html)->toContain('data-dialog-dismissible="false"');
});

it('renders flyout dialog positioning classes', function () {
    $html = Blade::render('<x-stencil::dialog.content flyout flyout-position="left">Panel</x-stencil::dialog.content>');

    expect($html)
        ->toContain('data-dialog-flyout="true"')
        ->toContain('left-0');
});

it('centers preview panels without fixed positioning offsets', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::dialog.content preview>
            <x-stencil::dialog.title>Preview</x-stencil::dialog.title>
        </x-stencil::dialog.content>
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
    $html = Blade::render('<x-stencil::dialog.cancel>Cancel</x-stencil::dialog.cancel>');

    expect($html)
        ->toContain('data-dialog-close')
        ->toContain('data-dialog-cancel')
        ->toContain('Cancel');
});
