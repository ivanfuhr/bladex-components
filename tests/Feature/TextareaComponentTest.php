<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a textarea control with name', function () {
    $html = Blade::render('<x-ui::textarea name="bio" placeholder="Tell us about yourself">Hello</x-ui::textarea>');

    expect($html)
        ->toContain('data-textarea')
        ->toContain('data-textarea-control')
        ->toContain('name="bio"')
        ->toContain('Hello');
});

it('marks textarea invalid when invalid prop is true', function () {
    $html = Blade::render('<x-ui::textarea name="bio" :invalid="true" />');

    expect($html)->toContain('aria-invalid="true"');
});

it('respects disabled on textarea', function () {
    $html = Blade::render('<x-ui::textarea name="bio" disabled />');

    expect($html)->toContain('disabled');
});

it('renders autosize and counter markers', function () {
    $html = Blade::render('<x-ui::textarea name="bio" autosize counter maxlength="200" />');

    expect($html)
        ->toContain('data-textarea-autosize')
        ->toContain('data-textarea-counter')
        ->toContain('data-textarea-counter-display')
        ->toContain('maxlength="200"');
});

it('nests the character counter display inside the textarea root', function () {
    $html = Blade::render('<x-ui::textarea name="bio" counter maxlength="200" />');

    $document = new DOMDocument;
    @$document->loadHTML($html);

    $control = $document->getElementById('bio');
    $root = $control?->parentNode;

    expect($root)->toBeInstanceOf(DOMElement::class)
        ->and($root->hasAttribute('data-textarea-counter'))->toBeTrue();

    $counter = null;

    foreach ($root->getElementsByTagName('div') as $div) {
        if ($div->hasAttribute('data-textarea-counter-display')) {
            $counter = $div;
            break;
        }
    }

    expect($counter)->toBeInstanceOf(DOMElement::class)
        ->and($counter->parentNode)->toBe($root);
});

it('keeps native attributes on the textarea control, not the wrapper', function () {
    $html = Blade::render(
        '<x-ui::textarea name="bio" placeholder="About you" rows="4" maxlength="200" />',
    );

    $document = new DOMDocument;
    @$document->loadHTML($html);

    $control = $document->getElementById('bio');
    $wrapper = $control?->parentNode;

    expect($control)->toBeInstanceOf(DOMElement::class)
        ->and($wrapper)->toBeInstanceOf(DOMElement::class)
        ->and($control->getAttribute('name'))->toBe('bio')
        ->and($control->getAttribute('placeholder'))->toBe('About you')
        ->and($control->getAttribute('rows'))->toBe('4')
        ->and($control->getAttribute('maxlength'))->toBe('200')
        ->and($wrapper->hasAttribute('data-textarea'))->toBeTrue()
        ->and($wrapper->hasAttribute('name'))->toBeFalse()
        ->and($wrapper->hasAttribute('placeholder'))->toBeFalse()
        ->and($wrapper->hasAttribute('rows'))->toBeFalse()
        ->and($wrapper->hasAttribute('maxlength'))->toBeFalse();
});
