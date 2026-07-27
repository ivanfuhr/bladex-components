<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a default outline button with data attributes', function () {
    $html = Blade::render('<x-stencil::button>Save</x-stencil::button>');

    expect($html)
        ->toContain('data-button')
        ->toContain('data-button-label')
        ->toContain('type="button"')
        ->toContain('Save')
        ->toContain('border-zinc-200')
        ->toContain('cursor-pointer');
});

it('renders a primary submit button', function () {
    $html = Blade::render('<x-stencil::button variant="primary" type="submit">Send</x-stencil::button>');

    expect($html)
        ->toContain('type="submit"')
        ->toContain('bg-zinc-900')
        ->toContain('Send');
});

it('renders as a link when href is provided', function () {
    $html = Blade::render('<x-stencil::button href="https://example.com">Visit</x-stencil::button>');

    expect($html)
        ->toContain('<a ')
        ->toContain('href="https://example.com"')
        ->not->toContain('type="button"');
});

it('renders leading and trailing slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::button>
            <x-slot:leading>
                <span data-test="leading">L</span>
            </x-slot:leading>
            Export
            <x-slot:trailing>
                <span data-test="trailing">T</span>
            </x-slot:trailing>
        </x-stencil::button>
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
        <x-stencil::button square>
            <x-slot:leading>
                <span data-test="icon">×</span>
            </x-slot:leading>
        </x-stencil::button>
    BLADE);

    expect($html)
        ->toContain('size-9')
        ->toContain('data-button-icon-only')
        ->not->toContain('data-button-label');
});

it('renders a grouped set of buttons', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::button.group>
            <x-stencil::button>One</x-stencil::button>
            <x-stencil::button>Two</x-stencil::button>
        </x-stencil::button.group>
    BLADE);

    expect($html)
        ->toContain('data-button-group')
        ->toContain('role="group"')
        ->toContain('One')
        ->toContain('Two');
});

it('accepts destructive as an alias for danger styling', function () {
    $html = Blade::render('<x-stencil::button variant="destructive">Delete</x-stencil::button>');

    expect($html)->toContain('bg-red-600');
});

it('forwards disabled and reflects loading with aria-busy and a spinner', function () {
    $html = Blade::render('<x-stencil::button disabled data-loading>Save</x-stencil::button>');

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
    $html = Blade::render('<x-stencil::button href="/docs" disabled>Docs</x-stencil::button>');

    expect($html)
        ->toContain('aria-disabled="true"')
        ->toContain('tabindex="-1"')
        ->not->toMatch('/<a[^>]*\sdisabled="/');
});

it('supports the loading prop as an alias for data-loading', function () {
    $html = Blade::render('<x-stencil::button :loading="true">Wait</x-stencil::button>');

    expect($html)
        ->toContain('data-loading')
        ->toContain('aria-busy="true"');
});
