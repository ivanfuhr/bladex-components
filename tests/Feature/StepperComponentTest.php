<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a stepper with list, indicators, and active panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::stepper default-value="account" stepper-id="setup">
            <x-stencil::stepper.list>
                <x-stencil::stepper.item value="account" :step="1">
                    <x-stencil::stepper.trigger>
                        <x-stencil::stepper.indicator />
                        <x-stencil::stepper.title>Account</x-stencil::stepper.title>
                        <x-stencil::stepper.description>Profile</x-stencil::stepper.description>
                    </x-stencil::stepper.trigger>
                    <x-stencil::stepper.separator />
                </x-stencil::stepper.item>
                <x-stencil::stepper.item value="workspace" :step="2">
                    <x-stencil::stepper.trigger>
                        <x-stencil::stepper.indicator />
                        <x-stencil::stepper.title>Workspace</x-stencil::stepper.title>
                    </x-stencil::stepper.trigger>
                </x-stencil::stepper.item>
            </x-stencil::stepper.list>
            <x-stencil::stepper.content value="account">Account panel</x-stencil::stepper.content>
            <x-stencil::stepper.content value="workspace">Workspace panel</x-stencil::stepper.content>
            <x-stencil::stepper.navigation>
                <x-stencil::stepper.previous />
                <x-stencil::stepper.next />
            </x-stencil::stepper.navigation>
        </x-stencil::stepper>
    BLADE);

    expect($html)
        ->toContain('data-stepper')
        ->toContain('data-stepper-list')
        ->toContain('data-stepper-item')
        ->toContain('data-stepper-trigger')
        ->toContain('data-stepper-indicator')
        ->toContain('data-stepper-title')
        ->toContain('data-stepper-description')
        ->toContain('data-stepper-separator')
        ->toContain('data-stepper-content')
        ->toContain('data-stepper-navigation')
        ->toContain('data-stepper-previous')
        ->toContain('data-stepper-next')
        ->toContain('data-state="active"')
        ->toContain('aria-current="step"')
        ->toContain('Account panel')
        ->toContain('Workspace panel')
        ->toContain('id="setup-trigger-account"')
        ->toContain('id="setup-panel-account"')
        ->toContain('aria-controls="setup-panel-account"')
        ->toContain('aria-labelledby="setup-trigger-account"');
});

it('supports vertical orientation and non-linear mode', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::stepper default-value="a" orientation="vertical" :linear="false">
            <x-stencil::stepper.list>
                <x-stencil::stepper.item value="a" :step="1">
                    <x-stencil::stepper.trigger>A</x-stencil::stepper.trigger>
                </x-stencil::stepper.item>
            </x-stencil::stepper.list>
        </x-stencil::stepper>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('data-linear="false"')
        ->toContain('aria-orientation="vertical"');
});

it('marks completed steps and disables items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::stepper default-value="b">
            <x-stencil::stepper.list>
                <x-stencil::stepper.item value="a" :step="1" :completed="true">
                    <x-stencil::stepper.trigger>
                        <x-stencil::stepper.indicator />
                    </x-stencil::stepper.trigger>
                </x-stencil::stepper.item>
                <x-stencil::stepper.item value="b" :step="2" disabled>
                    <x-stencil::stepper.trigger>B</x-stencil::stepper.trigger>
                </x-stencil::stepper.item>
            </x-stencil::stepper.list>
        </x-stencil::stepper>
    BLADE);

    expect($html)
        ->toContain('data-state="completed"')
        ->toContain('data-disabled="true"')
        ->toContain('disabled');
});
