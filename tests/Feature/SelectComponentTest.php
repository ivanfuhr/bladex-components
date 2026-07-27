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
