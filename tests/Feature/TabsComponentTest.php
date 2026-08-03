<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders tabs with selected trigger and panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::tabs default-value="account" variant="segmented">
            <x-ui::tabs.list>
                <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
                <x-ui::tabs.trigger value="password">Password</x-ui::tabs.trigger>
            </x-ui::tabs.list>
            <x-ui::tabs.content value="account">Account panel</x-ui::tabs.content>
            <x-ui::tabs.content value="password">Password panel</x-ui::tabs.content>
        </x-ui::tabs>
    BLADE);

    expect($html)
        ->toContain('data-tabs')
        ->toContain('role="tablist"')
        ->toContain('role="tab"')
        ->toContain('role="tabpanel"')
        ->toContain('aria-selected="true"')
        ->toContain('Account panel')
        ->toContain('Password panel')
        ->toContain('data-variant="segmented"');
});

it('wires tab ids with aria-controls and aria-labelledby', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::tabs default-value="account" tabs-id="settings">
            <x-ui::tabs.list>
                <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
            </x-ui::tabs.list>
            <x-ui::tabs.content value="account">Account panel</x-ui::tabs.content>
        </x-ui::tabs>
    BLADE);

    expect($html)
        ->toContain('id="settings-tab-account"')
        ->toContain('id="settings-panel-account"')
        ->toContain('aria-controls="settings-panel-account"')
        ->toContain('aria-labelledby="settings-tab-account"');
});

it('does not bleed the tab value into nested input-otp slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::tabs default-value="guests">
            <x-ui::tabs.content value="guests">
                <x-ui::input-otp name="door_pin" />
            </x-ui::tabs.content>
        </x-ui::tabs>
    BLADE);

    expect($html)
        ->not->toContain('value="g"')
        ->not->toContain('value="u"')
        ->not->toContain('value="e"')
        ->not->toContain('value="s"')
        ->not->toContain('value="t"');
});

it('marks disabled triggers', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::tabs default-value="a">
            <x-ui::tabs.list>
                <x-ui::tabs.trigger value="a">A</x-ui::tabs.trigger>
                <x-ui::tabs.trigger value="b" disabled>B</x-ui::tabs.trigger>
            </x-ui::tabs.list>
        </x-ui::tabs>
    BLADE);

    expect($html)->toContain('disabled');
});
