<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders a combobox root with hidden input and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" placeholder="Search…">
            <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('data-combobox')
        ->toContain('data-combobox-hidden-input')
        ->toContain('name="framework"')
        ->toContain('data-combobox-input')
        ->toContain('role="combobox"')
        ->toContain('aria-autocomplete="list"')
        ->toContain('data-combobox-content')
        ->toContain('role="listbox"')
        ->toContain('data-combobox-item')
        ->toContain('data-value="laravel"')
        ->toContain('data-combobox-empty')
        ->toContain('Laravel');
});

it('renders shortcut mode with placeholder on the input', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" placeholder="Search frameworks…">
            <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('placeholder="Search frameworks…"')
        ->toContain('No results found.');
});

it('renders full compound structure without duplicating the input', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" :shortcut="false">
            <x-stencil::combobox.input placeholder="Search…" />
            <x-stencil::combobox.content>
                <x-stencil::combobox.empty>Nothing here</x-stencil::combobox.empty>
                <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
            </x-stencil::combobox.content>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('data-combobox-input')
        ->toContain('aria-haspopup="listbox"')
        ->toContain('aria-expanded="false"')
        ->toContain('role="listbox"')
        ->toContain('role="option"')
        ->toContain('Nothing here')
        ->toContain('Laravel');

    expect(substr_count($html, 'data-combobox-input="') + substr_count($html, 'data-combobox-input '))
        ->toBeGreaterThanOrEqual(1);
    expect(substr_count($html, 'data-combobox-input-wrap'))->toBe(1);
    expect(preg_match_all('/\sdata-combobox-input(?:\s|=|>)/', $html))->toBe(1);
});

it('marks the input invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" :invalid="true" placeholder="Search…">
            <x-stencil::combobox.item value="a">A</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)->toContain('aria-invalid="true"');
});

it('disables the input when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" :disabled="true" placeholder="Search…">
            <x-stencil::combobox.item value="a">A</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)->toContain('disabled');
});

it('inherits field invalid state from the Field shell', function () {
    $bag = new MessageBag(['framework' => ['The framework field is required.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-stencil::field name="framework">
            <x-stencil::combobox name="framework" placeholder="Search…">
                <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
            </x-stencil::combobox>
        </x-stencil::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"');
});

it('renders group label and separator markup', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="fruit" placeholder="Fruit" :shortcut="false">
            <x-stencil::combobox.input />
            <x-stencil::combobox.content>
                <x-stencil::combobox.group>
                    <x-stencil::combobox.label>Citrus</x-stencil::combobox.label>
                    <x-stencil::combobox.item value="orange">Orange</x-stencil::combobox.item>
                </x-stencil::combobox.group>
                <x-stencil::combobox.separator />
                <x-stencil::combobox.item value="apple">Apple</x-stencil::combobox.item>
            </x-stencil::combobox.content>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('data-combobox-group')
        ->toContain('data-combobox-label')
        ->toContain('Citrus')
        ->toContain('data-combobox-separator');
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" placeholder="Search…">
            <x-stencil::combobox.item value="a">A</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)->toContain('class="combobox relative min-w-0 w-full"');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" class="w-36" placeholder="Search…">
            <x-stencil::combobox.item value="a">A</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)->toContain('class="combobox relative min-w-0 w-36"');
});

it('styles combobox options with hover feedback', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="x" placeholder="X">
            <x-stencil::combobox.item value="a">A</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('hover:bg-zinc-100')
        ->toContain('cursor-pointer');
});

it('marks disabled items with data-disabled', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="x" placeholder="X">
            <x-stencil::combobox.item value="a" :disabled="true">Locked</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('data-disabled')
        ->toContain('aria-disabled="true"');
});

it('wires aria-controls between the input and listbox', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" combobox-id="fw" placeholder="Search…">
            <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)
        ->toContain('id="fw-listbox"')
        ->toContain('aria-controls="fw-listbox"')
        ->toContain('id="fw"');
});

it('pre-fills the hidden input when a value is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::combobox name="framework" value="laravel" placeholder="Search…">
            <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
        </x-stencil::combobox>
    BLADE);

    expect($html)->toContain('value="laravel"');
    expect($html)->toContain('data-combobox-hidden-input');
});
