<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ViewException;

it('renders a pillbox with hidden inputs and chip template', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::pillbox name="tags" :value="['laravel', 'php']" placeholder="Add tags…" />
    BLADE);

    expect($html)
        ->toContain('data-pillbox')
        ->toContain('data-pillbox-name="tags[]"')
        ->toContain('data-pillbox-value="[&quot;laravel&quot;,&quot;php&quot;]"')
        ->toContain('data-pillbox-list')
        ->toContain('data-pillbox-hidden-inputs')
        ->toContain('name="tags[]"')
        ->toContain('value="laravel"')
        ->toContain('data-pillbox-chip-template');
});

it('renders max attribute when provided', function () {
    $html = Blade::render('<x-std::pillbox name="tags" :max="5" />');

    expect($html)->toContain('data-pillbox-max="5"');
});

it('requires a name attribute', function () {
    Blade::render('<x-std::pillbox />');
})->throws(ViewException::class);

it('marks pillbox invalid when inside field with errors', function () {
    $errors = new ViewErrorBag;
    $errors->put('default', new MessageBag(['tags' => 'Invalid tags.']));
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-std::field name="tags">
            <x-std::pillbox name="tags" />
        </x-std::field>
    BLADE);

    expect($html)->toContain('data-invalid="true"');
});
