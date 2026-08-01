<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders tabs with selected trigger and panel', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::tabs default-value="account" variant="segmented">
            <x-stencil::tabs.list>
                <x-stencil::tabs.trigger value="account">Account</x-stencil::tabs.trigger>
                <x-stencil::tabs.trigger value="password">Password</x-stencil::tabs.trigger>
            </x-stencil::tabs.list>
            <x-stencil::tabs.content value="account">Account panel</x-stencil::tabs.content>
            <x-stencil::tabs.content value="password">Password panel</x-stencil::tabs.content>
        </x-stencil::tabs>
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

it('marks disabled triggers', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::tabs default-value="a">
            <x-stencil::tabs.list>
                <x-stencil::tabs.trigger value="a">A</x-stencil::tabs.trigger>
                <x-stencil::tabs.trigger value="b" disabled>B</x-stencil::tabs.trigger>
            </x-stencil::tabs.list>
        </x-stencil::tabs>
    BLADE);

    expect($html)->toContain('disabled');
});
