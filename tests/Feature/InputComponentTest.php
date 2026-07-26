<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('registers the input anonymous component', function () {
    $paths = collect(Blade::getAnonymousComponentPaths())
        ->pluck('prefix')
        ->all();

    expect($paths)->toContain('bladex-components');
});

it('renders a text input with the control name on the native element', function () {
    $html = Blade::render('<x-bladex-components::input name="email" type="email" placeholder="you@example.com" />');

    expect($html)
        ->toContain('data-input')
        ->toContain('data-input-control')
        ->toContain('name="email"')
        ->toContain('type="email"')
        ->toContain('placeholder="you@example.com"');
});

it('merges wrapper class and forwards input:class to the control', function () {
    $html = Blade::render(
        '<x-bladex-components::input name="q" class="max-w-xs" input:class="font-mono" />',
    );

    expect($html)
        ->toContain('max-w-xs')
        ->toContain('font-mono')
        ->toContain('name="q"');
});

it('marks the control invalid when the invalid prop is true', function () {
    $html = Blade::render('<x-bladex-components::input name="title" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});

it('renders leading and trailing slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-bladex-components::input name="search">
            <x-slot:leading>
                <span data-test="leading-icon">⌕</span>
            </x-slot:leading>
            <x-slot:trailing>
                <span data-test="trailing-action">Clear</span>
            </x-slot:trailing>
        </x-bladex-components::input>
    BLADE);

    expect($html)
        ->toContain('data-test="leading-icon"')
        ->toContain('data-test="trailing-action"')
        ->toContain('input--with-affixes')
        ->toContain('input__leading')
        ->toContain('w-9')
        ->toContain('[&_[data-icon]]:size-4');
});

it('sizes icons in leading and trailing affixes to match the control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-bladex-components::input name="search">
            <x-slot:leading>
                <x-bladex-components::icon.loading />
            </x-slot:leading>
        </x-bladex-components::input>
    BLADE);

    expect($html)
        ->toContain('input__leading')
        ->toContain('[&_[data-icon]]:size-4')
        ->toContain('data-icon');
});

it('renders prefix and suffix from attributes', function () {
    $html = Blade::render(
        '<x-bladex-components::input name="website" prefix="https://" suffix=".test" class="max-w-md" placeholder="example.com" />',
    );

    expect($html)
        ->toContain('data-input-group')
        ->toContain('data-input-group-prefix')
        ->toContain('data-text')
        ->toContain('https://')
        ->toContain('data-input-group-suffix')
        ->toContain('.test')
        ->toContain('max-w-md')
        ->toContain('name="website"');
});

it('renders leading and trailing from attributes', function () {
    $html = Blade::render(
        '<x-bladex-components::input name="q" leading="⌕" trailing="⌘K" placeholder="Search" />',
    );

    expect($html)
        ->toContain('input__leading-text')
        ->toContain('data-text')
        ->toContain('⌕')
        ->toContain('input__trailing-text')
        ->toContain('⌘K');
});

it('prefers leading and trailing slots over attribute shorthands', function () {
    $html = Blade::render(<<<'BLADE'
        <x-bladex-components::input name="q" leading="ignored">
            <x-slot:leading>
                <span data-test="slot-leading">from-slot</span>
            </x-slot:leading>
        </x-bladex-components::input>
    BLADE);

    expect($html)
        ->toContain('data-test="slot-leading"')
        ->not->toContain('ignored');
});

it('renders an input group with prefix and suffix', function () {
    $html = Blade::render(<<<'BLADE'
        <x-bladex-components::input.group>
            <x-bladex-components::input.group.prefix>https://</x-bladex-components::input.group.prefix>
            <x-bladex-components::input name="website" in-group placeholder="example.com" />
            <x-bladex-components::input.group.suffix>.test</x-bladex-components::input.group.suffix>
        </x-bladex-components::input.group>
    BLADE);

    expect($html)
        ->toContain('data-input-group')
        ->toContain('data-input-group-prefix')
        ->toContain('data-input-group-suffix')
        ->toContain('name="website"');
});
