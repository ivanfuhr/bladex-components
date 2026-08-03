<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders a combobox root with hidden input and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" placeholder="Search…">
            <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        </x-ui::combobox>
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
        <x-ui::combobox name="framework" placeholder="Search frameworks…">
            <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('placeholder="Search frameworks…"')
        ->toContain('No results found.');
});

it('renders full compound structure without duplicating the input', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" :shortcut="false">
            <x-ui::combobox.input placeholder="Search…" />
            <x-ui::combobox.content>
                <x-ui::combobox.empty>Nothing here</x-ui::combobox.empty>
                <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
            </x-ui::combobox.content>
        </x-ui::combobox>
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
        <x-ui::combobox name="framework" :invalid="true" placeholder="Search…">
            <x-ui::combobox.item value="a">A</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)->toContain('aria-invalid="true"');
});

it('disables the input when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" :disabled="true" placeholder="Search…">
            <x-ui::combobox.item value="a">A</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)->toContain('disabled');
});

it('inherits field invalid state from the Field shell', function () {
    $bag = new MessageBag(['framework' => ['The framework field is required.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="framework">
            <x-ui::combobox name="framework" placeholder="Search…">
                <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
            </x-ui::combobox>
        </x-ui::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"');
});

it('renders group label and separator markup', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="fruit" placeholder="Fruit" :shortcut="false">
            <x-ui::combobox.input />
            <x-ui::combobox.content>
                <x-ui::combobox.group>
                    <x-ui::combobox.label>Citrus</x-ui::combobox.label>
                    <x-ui::combobox.item value="orange">Orange</x-ui::combobox.item>
                </x-ui::combobox.group>
                <x-ui::combobox.separator />
                <x-ui::combobox.item value="apple">Apple</x-ui::combobox.item>
            </x-ui::combobox.content>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('data-combobox-group')
        ->toContain('data-combobox-label')
        ->toContain('Citrus')
        ->toContain('data-combobox-separator');
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" placeholder="Search…">
            <x-ui::combobox.item value="a">A</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)->toContain('class="combobox relative min-w-0 w-full"');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" class="w-36" placeholder="Search…">
            <x-ui::combobox.item value="a">A</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)->toContain('class="combobox relative min-w-0 w-36"');
});

it('styles combobox options with hover feedback', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="x" placeholder="X">
            <x-ui::combobox.item value="a">A</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('hover:bg-zinc-100')
        ->toContain('cursor-pointer');
});

it('marks disabled items with data-disabled', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="x" placeholder="X">
            <x-ui::combobox.item value="a" :disabled="true">Locked</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('data-disabled')
        ->toContain('aria-disabled="true"');
});

it('wires aria-controls between the input and listbox', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" combobox-id="fw" placeholder="Search…">
            <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('id="fw-listbox"')
        ->toContain('aria-controls="fw-listbox"')
        ->toContain('id="fw"');
});

it('pre-fills the hidden input when a value is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="framework" value="laravel" placeholder="Search…">
            <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)->toContain('value="laravel"');
    expect($html)->toContain('data-combobox-hidden-input');
});

it('renders multiple combobox with hidden inputs and chips display', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::combobox name="frameworks" multiple display="chips" :value="['laravel', 'vue']">
            <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
            <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
        </x-ui::combobox>
    BLADE);

    expect($html)
        ->toContain('data-combobox-multiple')
        ->toContain('data-combobox-display="chips"')
        ->toContain('data-combobox-hidden-inputs')
        ->toContain('name="frameworks[]"')
        ->toContain('value="laravel"')
        ->toContain('value="vue"')
        ->toContain('data-combobox-chips')
        ->toContain('data-combobox-filter-input');
});

it('combobox script removes orphaned portaled content on remount', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/combobox.js');

    expect($source)
        ->toContain('[data-combobox-content][data-combobox-portaled]')
        ->toContain("content.closest('[data-combobox]')")
        ->toContain('content.remove()')
        ->toContain('createBindSignal')
        ->toContain('stencil:mount');
});
