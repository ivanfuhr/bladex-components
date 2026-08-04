<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a default outline button with data attributes', function () {
    $html = Blade::render('<x-ui::button>Save</x-ui::button>');

    expect($html)
        ->toContain('data-button')
        ->toContain('data-button-label')
        ->toContain('type="button"')
        ->toContain('Save')
        ->toContain('border-zinc-200')
        ->toContain('cursor-pointer');
});

it('renders a primary submit button', function () {
    $html = Blade::render('<x-ui::button variant="primary" type="submit">Send</x-ui::button>');

    expect($html)
        ->toContain('type="submit"')
        ->toContain('bg-zinc-900')
        ->toContain('Send');
});

it('renders as a link when href is provided', function () {
    $html = Blade::render('<x-ui::button href="https://example.com">Visit</x-ui::button>');

    expect($html)
        ->toContain('<a ')
        ->toContain('href="https://example.com"')
        ->not->toContain('type="button"');
});

it('renders leading and trailing slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::button>
            <x-slot:leading>
                <span data-test="leading">L</span>
            </x-slot:leading>
            Export
            <x-slot:trailing>
                <span data-test="trailing">T</span>
            </x-slot:trailing>
        </x-ui::button>
    BLADE);

    expect($html)
        ->toContain('data-button-leading')
        ->toContain('data-button-trailing')
        ->toContain('data-test="leading"')
        ->toContain('data-test="trailing"')
        ->toContain('Export');
});

it('renders an icon-only square control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::button square>
            <x-slot:leading>
                <span data-test="icon">×</span>
            </x-slot:leading>
        </x-ui::button>
    BLADE);

    expect($html)
        ->toContain('size-11')
        ->toContain('data-button-icon-only')
        ->not->toContain('data-button-label');
});

it('renders a grouped set of buttons', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::button.group>
            <x-ui::button>One</x-ui::button>
            <x-ui::button>Two</x-ui::button>
        </x-ui::button.group>
    BLADE);

    expect($html)
        ->toContain('data-button-group')
        ->toContain('role="group"')
        ->toContain('One')
        ->toContain('Two');
});

it('accepts destructive as an alias for danger styling', function () {
    $html = Blade::render('<x-ui::button variant="destructive">Delete</x-ui::button>');

    expect($html)->toContain('bg-red-600');
});

it('forwards disabled and reflects loading with aria-busy and a spinner', function () {
    $html = Blade::render('<x-ui::button disabled data-loading>Save</x-ui::button>');

    expect($html)
        ->toContain('disabled')
        ->toContain('data-loading')
        ->toContain('aria-busy="true"')
        ->toContain('data-button-loading')
        ->toContain('data-button-loading-icon')
        ->toContain('animate-spin')
        ->toContain('data-loading:cursor-wait');
});

it('maps disabled links to aria-disabled', function () {
    $html = Blade::render('<x-ui::button href="/docs" disabled>Docs</x-ui::button>');

    expect($html)
        ->toContain('aria-disabled="true"')
        ->toContain('tabindex="-1"')
        ->not->toMatch('/<a[^>]*\sdisabled="/');
});

it('supports the loading prop as an alias for data-loading', function () {
    $html = Blade::render('<x-ui::button :loading="true">Wait</x-ui::button>');

    expect($html)
        ->toContain('data-loading')
        ->toContain('aria-busy="true"');
});
