<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a stepper with list, indicators, and active panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::stepper default-value="account" stepper-id="setup">
            <x-std::stepper.list>
                <x-std::stepper.item value="account" :step="1">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                        <x-std::stepper.title>Account</x-std::stepper.title>
                        <x-std::stepper.description>Profile</x-std::stepper.description>
                    </x-std::stepper.trigger>
                    <x-std::stepper.separator />
                </x-std::stepper.item>
                <x-std::stepper.item value="workspace" :step="2">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                        <x-std::stepper.title>Workspace</x-std::stepper.title>
                    </x-std::stepper.trigger>
                </x-std::stepper.item>
            </x-std::stepper.list>
            <x-std::stepper.content value="account">Account panel</x-std::stepper.content>
            <x-std::stepper.content value="workspace">Workspace panel</x-std::stepper.content>
            <x-std::stepper.navigation>
                <x-std::stepper.previous />
                <x-std::stepper.next />
            </x-std::stepper.navigation>
        </x-std::stepper>
    BLADE);

    expect($html)
        ->toContain('data-stepper')
        ->toContain('aria-label="Steps"')
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
        <x-std::stepper default-value="a" orientation="vertical" :linear="false">
            <x-std::stepper.list>
                <x-std::stepper.item value="a" :step="1">
                    <x-std::stepper.trigger>A</x-std::stepper.trigger>
                </x-std::stepper.item>
            </x-std::stepper.list>
        </x-std::stepper>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('data-linear="false"')
        ->toContain('aria-orientation="vertical"');
});

it('marks completed steps and disables items', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::stepper default-value="b">
            <x-std::stepper.list>
                <x-std::stepper.item value="a" :step="1" :completed="true">
                    <x-std::stepper.trigger>
                        <x-std::stepper.indicator />
                    </x-std::stepper.trigger>
                </x-std::stepper.item>
                <x-std::stepper.item value="b" :step="2" disabled>
                    <x-std::stepper.trigger>B</x-std::stepper.trigger>
                </x-std::stepper.item>
            </x-std::stepper.list>
        </x-std::stepper>
    BLADE);

    expect($html)
        ->toContain('data-state="completed"')
        ->toContain('data-disabled="true"')
        ->toContain('disabled');
});
