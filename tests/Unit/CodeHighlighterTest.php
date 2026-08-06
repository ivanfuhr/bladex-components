<?php

declare(strict_types=1);

use Ivanfuhr\StdComponents\Support\Code\CodeHighlighter;

it('highlights blade tags, attributes, and directives', function () {
    $code = <<<'BLADE'
<x-std::button-group aria-label="Actions">
    <x-std::button variant="outline">Archive</x-std::button>
</x-std::button-group>
BLADE;

    $html = (new CodeHighlighter)->highlight($code, 'blade');

    expect($html)
        ->toContain('code-block__token--tag')
        ->toContain('code-block__token--attr')
        ->toContain('code-block__token--string')
        ->toContain('x-std::button-group')
        ->toContain('aria-label')
        ->toContain('&quot;Actions&quot;');
});

it('highlights blade echo and comment syntax', function () {
    $code = "{{ \$name }}\n{{-- hidden --}}";

    $html = (new CodeHighlighter)->highlight($code, 'blade');

    expect($html)
        ->toContain('code-block__token--echo')
        ->toContain('code-block__token--comment');
});

it('highlights bash commands and flags', function () {
    $code = "composer require ivanfuhr/std-components\nphp artisan vendor:publish --tag=std-components-config";

    $html = (new CodeHighlighter)->highlight($code, 'bash');

    expect($html)
        ->toContain('code-block__token--command')
        ->toContain('code-block__token--flag')
        ->toContain('composer')
        ->toContain('--tag=std-components-config');
});

it('wraps markdown code blocks with the code block chrome', function () {
    $markdownHtml = '<pre><code class="language-blade">&lt;x-std::button&gt;Save&lt;/x-std::button&gt;</code></pre>';

    $html = (new CodeHighlighter)->highlightHtmlDocument($markdownHtml);

    expect($html)
        ->toContain('data-code-block')
        ->toContain('data-code-block-copy')
        ->toContain('code-block__token--tag')
        ->toContain('language-blade')
        ->toContain('&lt;x-std::button&gt;');
});
