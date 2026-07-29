<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a select root with hidden input and data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" placeholder="Choose…">
            <x-stencil::select.item value="photo">Photography</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select')
        ->toContain('data-select-hidden-input')
        ->toContain('name="industry"')
        ->toContain('data-select-trigger')
        ->toContain('data-select-content')
        ->toContain('data-select-value')
        ->toContain('data-select-item')
        ->toContain('data-value="photo"')
        ->toContain('Photography');
});

it('renders shortcut mode with placeholder on the value element', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" placeholder="Choose industry…">
            <x-stencil::select.item value="other">Other</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-placeholder="true"')
        ->toContain('Choose industry…');
});

it('renders full compound structure without duplicating trigger wrapper', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="role" :shortcut="false">
            <x-stencil::select.trigger>
                <x-stencil::select.value placeholder="Role" />
            </x-stencil::select.trigger>
            <x-stencil::select.content>
                <x-stencil::select.item value="admin">Admin</x-stencil::select.item>
            </x-stencil::select.content>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select-trigger')
        ->toContain('aria-haspopup="listbox"')
        ->toContain('aria-expanded="false"')
        ->toContain('role="listbox"')
        ->toContain('role="option"')
        ->toContain('Admin');

    expect(substr_count($html, 'data-select-trigger'))->toBe(1);
});

it('marks the trigger invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" :invalid="true" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)->toContain('aria-invalid="true"');
});

it('disables the trigger when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" :disabled="true" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)->toContain('disabled');
});

it('renders group label and separator markup', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="fruit" placeholder="Fruit" :shortcut="false">
            <x-stencil::select.trigger>
                <x-stencil::select.value />
            </x-stencil::select.trigger>
            <x-stencil::select.content>
                <x-stencil::select.group>
                    <x-stencil::select.label>Citrus</x-stencil::select.label>
                    <x-stencil::select.item value="orange">Orange</x-stencil::select.item>
                </x-stencil::select.group>
                <x-stencil::select.separator />
                <x-stencil::select.item value="apple">Apple</x-stencil::select.item>
            </x-stencil::select.content>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select-group')
        ->toContain('data-select-label')
        ->toContain('Citrus')
        ->toContain('data-select-separator');
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)->toContain('class="select relative min-w-0 w-full"');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="industry" class="w-36" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)->toContain('class="select relative min-w-0 w-36"');
});

it('styles select options with hover feedback', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="x" placeholder="X">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('hover:bg-zinc-100')
        ->toContain('cursor-pointer');
});

it('uses a pointer cursor on the select trigger', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="x" placeholder="X">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select-trigger')
        ->toContain('cursor-pointer');
});

it('marks disabled items with data-disabled', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="x" placeholder="X">
            <x-stencil::select.item value="a" :disabled="true">Locked</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-disabled')
        ->toContain('aria-disabled="true"');
});

it('normalizes the field name and exposes multiple data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="tags" :multiple="true" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select-multiple')
        ->toContain('data-select-display="count"')
        ->toContain('name="tags[]"')
        ->toContain('data-select-hidden-inputs')
        ->toContain('data-select-count-template');
});

it('renders one hidden input per selected value for multiple selects', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="tags" :multiple="true" :value="['photo', 'web']" placeholder="Choose…">
            <x-stencil::select.item value="photo">Photo</x-stencil::select.item>
            <x-stencil::select.item value="web">Web</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('value="photo"')
        ->toContain('value="web"')
        ->toContain('data-select-hidden-inputs');

    expect(preg_match_all('/<input[^>]*data-select-hidden-input[^>]*>/', $html))->toBe(2);
});

it('marks the listbox as multiselectable when multiple is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="tags" :multiple="true" placeholder="Choose…" :shortcut="false">
            <x-stencil::select.trigger>
                <x-stencil::select.value placeholder="Choose…" />
            </x-stencil::select.trigger>
            <x-stencil::select.content>
                <x-stencil::select.item value="a">A</x-stencil::select.item>
            </x-stencil::select.content>
        </x-stencil::select>
    BLADE);

    expect($html)->toContain('aria-multiselectable="true"');
});

it('renders chips primitives and chip template when display is chips', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="tags" :multiple="true" display="chips" placeholder="Choose…">
            <x-stencil::select.item value="a">A</x-stencil::select.item>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('data-select-chips')
        ->toContain('data-select-chip-template')
        ->toContain('data-select-display="chips"');
});

it('supports compound multiple layout with a single trigger', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::select name="roles" :multiple="true" :shortcut="false">
            <x-stencil::select.trigger>
                <x-stencil::select.value placeholder="Roles" />
            </x-stencil::select.trigger>
            <x-stencil::select.content>
                <x-stencil::select.item value="admin">Admin</x-stencil::select.item>
            </x-stencil::select.content>
        </x-stencil::select>
    BLADE);

    expect($html)
        ->toContain('name="roles[]"')
        ->toContain('data-select-trigger')
        ->toContain('role="listbox"')
        ->toContain('aria-multiselectable="true"');

    expect(substr_count($html, 'data-select-trigger'))->toBe(1);
});
