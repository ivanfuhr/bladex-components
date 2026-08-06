<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a highlighted code block with copy controls', function () {
    $html = Blade::render('<x-std::code-block language="blade" :code="$code" />', [
        'code' => '<x-std::button variant="outline">Save</x-std::button>',
    ]);

    expect($html)
        ->toContain('data-code-block')
        ->toContain('data-code-block-copy')
        ->toContain('data-code-block-content')
        ->toContain('code-block__token--tag')
        ->toContain('code-block__language')
        ->toContain('blade')
        ->toContain('Copy')
        ->toContain('&lt;x-std::button');
});

it('renders inline code without the toolbar', function () {
    $html = Blade::render('<x-std::code-block inline language="bash" code="composer require ivanfuhr/std-components" />');

    expect($html)
        ->toContain('data-code-block-inline')
        ->toContain('code-block--inline')
        ->not->toContain('data-code-block-copy')
        ->toContain('code-block__token--command')
        ->toContain('require ivanfuhr/std-components');
});

it('can hide the copy button', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::code-block :copyable="false" language="json" code='{"ok":true}' />
    BLADE);

    expect($html)
        ->toContain('data-code-block')
        ->not->toContain('data-code-block-copy')
        ->not->toContain('code-block__toolbar');
});

it('accepts slot content as the code source', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::code-block language="bash">
        composer require ivanfuhr/std-components
        </x-std::code-block>
    BLADE);

    expect($html)
        ->toContain('composer require ivanfuhr/std-components')
        ->toContain('code-block__token--command');
});
