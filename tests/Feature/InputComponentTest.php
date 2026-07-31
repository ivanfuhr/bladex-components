<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('registers the input anonymous component', function () {
    $paths = collect(Blade::getAnonymousComponentPaths())
        ->pluck('prefix')
        ->all();

    expect($paths)->toContain('stencil');
});

it('renders a text input with the control name on the native element', function () {
    $html = Blade::render('<x-stencil::input name="email" type="email" placeholder="you@example.com" />');

    expect($html)
        ->toContain('data-input')
        ->toContain('data-input-control')
        ->toContain('name="email"')
        ->toContain('type="email"')
        ->toContain('placeholder="you@example.com"');
});

it('merges wrapper class and forwards input:class to the control', function () {
    $html = Blade::render(
        '<x-stencil::input name="q" class="max-w-xs" input:class="font-mono" />',
    );

    expect($html)
        ->toContain('max-w-xs')
        ->toContain('font-mono')
        ->toContain('name="q"');
});

it('marks the control invalid when the invalid prop is true', function () {
    $html = Blade::render('<x-stencil::input name="title" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});

it('renders leading and trailing slots', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input name="search">
            <x-slot:leading>
                <span data-test="leading-icon">⌕</span>
            </x-slot:leading>
            <x-slot:trailing>
                <span data-test="trailing-action">Clear</span>
            </x-slot:trailing>
        </x-stencil::input>
    BLADE);

    expect($html)
        ->toContain('data-test="leading-icon"')
        ->toContain('data-test="trailing-action"')
        ->toContain('input--with-affixes')
        ->toContain('input__leading')
        ->toContain('!pl-9')
        ->toContain('!pr-14')
        ->toContain('w-9')
        ->toContain('w-14')
        ->toContain('[&_[data-icon]]:size-4');
});

it('sizes icons in leading and trailing affixes to match the control', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input name="search">
            <x-slot:leading>
                <x-stencil::icon.loading />
            </x-slot:leading>
        </x-stencil::input>
    BLADE);

    expect($html)
        ->toContain('input__leading')
        ->toContain('[&_[data-icon]]:size-4')
        ->toContain('data-icon');
});

it('renders prefix and suffix from attributes', function () {
    $html = Blade::render(
        '<x-stencil::input name="website" prefix="https://" suffix=".test" class="max-w-md" placeholder="example.com" />',
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
        '<x-stencil::input name="q" leading="⌕" trailing="⌘K" placeholder="Search" />',
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
        <x-stencil::input name="q" leading="ignored">
            <x-slot:leading>
                <span data-test="slot-leading">from-slot</span>
            </x-slot:leading>
        </x-stencil::input>
    BLADE);

    expect($html)
        ->toContain('data-test="slot-leading"')
        ->not->toContain('ignored');
});

it('renders an input group with prefix and suffix', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input.group>
            <x-stencil::input.group.prefix>https://</x-stencil::input.group.prefix>
            <x-stencil::input name="website" in-group placeholder="example.com" />
            <x-stencil::input.group.suffix>.test</x-stencil::input.group.suffix>
        </x-stencil::input.group>
    BLADE);

    expect($html)
        ->toContain('data-input-group')
        ->toContain('data-input-group-prefix')
        ->toContain('data-input-group-suffix')
        ->toContain('name="website"');
});

it('forwards disabled, readonly, and loading attributes to the native control', function () {
    $html = Blade::render(
        '<x-stencil::input name="email" disabled readonly data-loading />',
    );

    expect($html)
        ->toContain('data-input-control')
        ->toContain('disabled')
        ->toContain('readonly')
        ->toContain('data-loading')
        ->toContain('aria-busy="true"')
        ->toContain('cursor-text')
        ->toContain('read-only:cursor-default')
        ->toContain('data-loading:cursor-wait');
});

it('renders input enhancement markers for mask, viewable, copyable, and counter', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::input name="phone" mask="phone" counter maxlength="20" />
        <x-stencil::input name="password" type="password" viewable />
        <x-stencil::input name="token" copyable />
    BLADE);

    expect($html)
        ->toContain('data-input-enhanced')
        ->toContain('data-input-mask="phone"')
        ->toContain('data-input-counter')
        ->toContain('data-input-counter-display')
        ->toContain('data-input-viewable')
        ->toContain('data-input-view-toggle')
        ->toContain('data-input-copyable')
        ->toContain('data-input-copy');
});
