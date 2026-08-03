<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a stepper with list, indicators, and active panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::stepper default-value="account" stepper-id="setup">
            <x-ui::stepper.list>
                <x-ui::stepper.item value="account" :step="1">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                        <x-ui::stepper.title>Account</x-ui::stepper.title>
                        <x-ui::stepper.description>Profile</x-ui::stepper.description>
                    </x-ui::stepper.trigger>
                    <x-ui::stepper.separator />
                </x-ui::stepper.item>
                <x-ui::stepper.item value="workspace" :step="2">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                        <x-ui::stepper.title>Workspace</x-ui::stepper.title>
                    </x-ui::stepper.trigger>
                </x-ui::stepper.item>
            </x-ui::stepper.list>
            <x-ui::stepper.content value="account">Account panel</x-ui::stepper.content>
            <x-ui::stepper.content value="workspace">Workspace panel</x-ui::stepper.content>
            <x-ui::stepper.navigation>
                <x-ui::stepper.previous />
                <x-ui::stepper.next />
            </x-ui::stepper.navigation>
        </x-ui::stepper>
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
        <x-ui::stepper default-value="a" orientation="vertical" :linear="false">
            <x-ui::stepper.list>
                <x-ui::stepper.item value="a" :step="1">
                    <x-ui::stepper.trigger>A</x-ui::stepper.trigger>
                </x-ui::stepper.item>
            </x-ui::stepper.list>
        </x-ui::stepper>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('data-linear="false"')
        ->toContain('aria-orientation="vertical"');
});

it('marks completed steps and disables items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::stepper default-value="b">
            <x-ui::stepper.list>
                <x-ui::stepper.item value="a" :step="1" :completed="true">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.indicator />
                    </x-ui::stepper.trigger>
                </x-ui::stepper.item>
                <x-ui::stepper.item value="b" :step="2" disabled>
                    <x-ui::stepper.trigger>B</x-ui::stepper.trigger>
                </x-ui::stepper.item>
            </x-ui::stepper.list>
        </x-ui::stepper>
    BLADE);

    expect($html)
        ->toContain('data-state="completed"')
        ->toContain('data-disabled="true"')
        ->toContain('disabled');
});
