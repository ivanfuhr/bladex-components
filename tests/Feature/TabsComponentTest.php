<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders tabs with selected trigger and panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::tabs default-value="account" variant="segmented">
            <x-std::tabs.list>
                <x-std::tabs.trigger value="account">Account</x-std::tabs.trigger>
                <x-std::tabs.trigger value="password">Password</x-std::tabs.trigger>
            </x-std::tabs.list>
            <x-std::tabs.content value="account">Account panel</x-std::tabs.content>
            <x-std::tabs.content value="password">Password panel</x-std::tabs.content>
        </x-std::tabs>
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
        <x-std::tabs default-value="account" tabs-id="settings">
            <x-std::tabs.list>
                <x-std::tabs.trigger value="account">Account</x-std::tabs.trigger>
            </x-std::tabs.list>
            <x-std::tabs.content value="account">Account panel</x-std::tabs.content>
        </x-std::tabs>
    BLADE);

    expect($html)
        ->toContain('id="settings-tab-account"')
        ->toContain('id="settings-panel-account"')
        ->toContain('aria-controls="settings-panel-account"')
        ->toContain('aria-labelledby="settings-tab-account"');
});

it('does not bleed the tab value into nested input-otp slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::tabs default-value="guests">
            <x-std::tabs.content value="guests">
                <x-std::input-otp name="door_pin" />
            </x-std::tabs.content>
        </x-std::tabs>
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
        <x-std::tabs default-value="a">
            <x-std::tabs.list>
                <x-std::tabs.trigger value="a">A</x-std::tabs.trigger>
                <x-std::tabs.trigger value="b" disabled>B</x-std::tabs.trigger>
            </x-std::tabs.list>
        </x-std::tabs>
    BLADE);

    expect($html)->toContain('disabled');
});
