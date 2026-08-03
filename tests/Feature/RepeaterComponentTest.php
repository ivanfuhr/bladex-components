<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ViewException;

it('renders a repeater root with list host and item template', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members" :value="[['name' => 'Ada', 'role' => 'owner']]">
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
                <x-ui::input data-repeater-field="role" />
                <x-ui::repeater.remove />
            </x-ui::repeater.item>
            <x-ui::repeater.add>Add member</x-ui::repeater.add>
        </x-ui::repeater>
    BLADE);

    expect($html)
        ->toContain('data-repeater')
        ->toContain('data-repeater-name="members"')
        ->toContain('data-repeater-value="[{&quot;name&quot;:&quot;Ada&quot;,&quot;role&quot;:&quot;owner&quot;}]"')
        ->toContain('data-repeater-list')
        ->toContain('data-repeater-item-template')
        ->toContain('data-repeater-field="name"')
        ->toContain('data-repeater-field="role"')
        ->toContain('data-repeater-add')
        ->toContain('data-repeater-remove')
        ->toContain('Add member');
});

it('renders min and max data attributes', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members" :min="1" :max="5">
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
            </x-ui::repeater.item>
        </x-ui::repeater>
    BLADE);

    expect($html)
        ->toContain('data-repeater-min="1"')
        ->toContain('data-repeater-max="5"');
});

it('marks the repeater invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members" :invalid="true">
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
            </x-ui::repeater.item>
        </x-ui::repeater>
    BLADE);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('data-invalid="true"');
});

it('marks the repeater disabled when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members" :disabled="true">
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
            </x-ui::repeater.item>
            <x-ui::repeater.add />
        </x-ui::repeater>
    BLADE);

    expect($html)->toContain('data-disabled="true"');
});

it('inherits field invalid state from the field wrapper', function () {
    $errors = new ViewErrorBag;
    $errors->put('default', new MessageBag(['members' => 'Invalid members.']));

    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-ui::field name="members">
            <x-ui::repeater name="members">
                <x-ui::repeater.item>
                    <x-ui::input data-repeater-field="name" />
                </x-ui::repeater.item>
            </x-ui::repeater>
        </x-ui::field>
    BLADE);

    expect($html)->toContain('data-invalid="true"');
});

it('requires a name attribute', function () {
    Blade::render(<<<'BLADE'
        <x-ui::repeater>
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
            </x-ui::repeater.item>
        </x-ui::repeater>
    BLADE);
})->throws(ViewException::class);

it('uses translated labels for add and remove actions', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members">
            <x-ui::repeater.item>
                <x-ui::input data-repeater-field="name" />
                <x-ui::repeater.remove />
            </x-ui::repeater.item>
            <x-ui::repeater.add />
        </x-ui::repeater>
    BLADE);

    expect($html)
        ->toContain('Add item')
        ->toContain('aria-label="Remove item"');
});

it('renders duplicate and sortable markers', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::repeater name="members" sortable>
            <x-ui::repeater.item>
                <x-ui::repeater.handle />
                <x-ui::input data-repeater-field="name" />
                <x-ui::repeater.duplicate />
                <x-ui::repeater.remove />
            </x-ui::repeater.item>
        </x-ui::repeater>
    BLADE);

    expect($html)
        ->toContain('data-repeater-sortable')
        ->toContain('data-repeater-duplicate')
        ->toContain('aria-label="Duplicate item"')
        ->toContain('data-repeater-handle')
        ->toContain('aria-label="Reorder item"');
});
