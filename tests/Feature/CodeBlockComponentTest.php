<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a highlighted code block with copy controls', function () {
    $html = Blade::render('<x-ui::code-block language="blade" :code="$code" />', [
        'code' => '<x-ui::button variant="outline">Save</x-ui::button>',
    ]);

    expect($html)
        ->toContain('data-code-block')
        ->toContain('data-code-block-copy')
        ->toContain('data-code-block-content')
        ->toContain('code-block__token--tag')
        ->toContain('code-block__language')
        ->toContain('blade')
        ->toContain('Copy')
        ->toContain('&lt;x-ui::button');
});

it('renders inline code without the toolbar', function () {
    $html = Blade::render('<x-ui::code-block inline language="bash" code="composer require ivanfuhr/stencil" />');

    expect($html)
        ->toContain('data-code-block-inline')
        ->toContain('code-block--inline')
        ->not->toContain('data-code-block-copy')
        ->toContain('code-block__token--command')
        ->toContain('require ivanfuhr/stencil');
});

it('can hide the copy button', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::code-block :copyable="false" language="json" code='{"ok":true}' />
    BLADE);

    expect($html)
        ->toContain('data-code-block')
        ->not->toContain('data-code-block-copy')
        ->not->toContain('code-block__toolbar');
});

it('accepts slot content as the code source', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::code-block language="bash">
        composer require ivanfuhr/stencil
        </x-ui::code-block>
    BLADE);

    expect($html)
        ->toContain('composer require ivanfuhr/stencil')
        ->toContain('code-block__token--command');
});
