<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a closed collapsible with trigger and content', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible>
            <x-ui::collapsible.trigger>Toggle details</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Hidden by default.</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-collapsible')
        ->toContain('data-state="closed"')
        ->toContain('data-collapsible-trigger')
        ->toContain('data-collapsible-content')
        ->toContain('aria-expanded="false"')
        ->toContain('Toggle details')
        ->toContain('Hidden by default.')
        ->toContain('hidden');
});

it('renders an open collapsible and disabled state', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible :open="true" disabled transition>
            <x-ui::collapsible.trigger>Open panel</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Visible content.</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-state="open"')
        ->toContain('data-collapsible-disabled="true"')
        ->toContain('data-collapsible-transition="true"')
        ->toContain('aria-expanded="true"')
        ->toContain('disabled')
        ->toContain('Visible content.');
});

it('keeps closed transition content inert for assistive tech', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible transition>
            <x-ui::collapsible.trigger>Toggle</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Hidden body.</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-transition="true"')
        ->toContain('aria-hidden="true"')
        ->toContain('inert');
});

it('supports as-child trigger wrapping', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible>
            <x-ui::collapsible.trigger as-child>
                <x-ui::button variant="outline">More</x-ui::button>
            </x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Details</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    expect($html)
        ->toContain('data-collapsible-trigger')
        ->toContain('contents')
        ->toContain('More')
        ->toContain('Details');
});

it('wires aria-controls between trigger and content on the server', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible trigger-id="col-trigger" content-id="col-content">
            <x-ui::collapsible.trigger>Toggle</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Body</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    expect($html)
        ->toContain('id="col-trigger"')
        ->toContain('id="col-content"')
        ->toContain('aria-controls="col-content"')
        ->toContain('aria-labelledby="col-trigger"')
        ->toContain('role="region"')
        ->toContain('data-collapsible-trigger-id="col-trigger"')
        ->toContain('data-collapsible-content-id="col-content"');
});

it('keeps auto-generated trigger and content ids consistent', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::collapsible>
            <x-ui::collapsible.trigger>Toggle</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Body</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE);

    preg_match('/aria-controls="([^"]+)"/', $html, $controls);
    preg_match('/aria-labelledby="([^"]+)"/', $html, $labelled);
    preg_match('/data-collapsible-trigger-id="([^"]+)"/', $html, $rootTrigger);
    preg_match('/data-collapsible-content-id="([^"]+)"/', $html, $rootContent);

    expect($controls[1] ?? null)->not->toBeNull()
        ->and($labelled[1] ?? null)->not->toBeNull()
        ->and($html)->toContain('id="'.($labelled[1] ?? '').'"')
        ->and($html)->toContain('id="'.($controls[1] ?? '').'"')
        ->and($rootTrigger[1] ?? null)->toBe($labelled[1] ?? null)
        ->and($rootContent[1] ?? null)->toBe($controls[1] ?? null);
});
