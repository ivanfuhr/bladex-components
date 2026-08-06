<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Support\Code;

final class CodeHighlighter
{
    /** @var array<string, string> */
    private const array LANGUAGE_ALIASES = [
        'shell' => 'bash',
        'sh' => 'bash',
        'zsh' => 'bash',
        'xml' => 'html',
    ];

    public function highlight(string $code, ?string $language = null): string
    {
        $language = $this->normalizeLanguage($language);
        $tokens = match ($language) {
            'blade', 'html' => $this->tokenizeMarkup($code),
            'php' => $this->tokenizePhp($code),
            'bash' => $this->tokenizeBash($code),
            'json' => $this->tokenizeJson($code),
            'css' => $this->tokenizeCss($code),
            default => [['type' => 'plain', 'value' => $code]],
        };

        return $this->renderTokens($tokens);
    }

    public function highlightHtmlDocument(string $html): string
    {
        return (string) preg_replace_callback(
            '/<pre><code(?: class="language-([\w-]+)")?>(.*?)<\/code><\/pre>/s',
            function (array $matches): string {
                $language = $matches[1] !== '' ? $matches[1] : 'text';
                $code = html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $highlighted = $this->highlight($code, $language);

                return $this->renderBlock($highlighted, $language, $code);
            },
            $html,
        );
    }

    public function renderBlock(string $highlighted, string $language, string $rawCode): string
    {
        $language = $this->normalizeLanguage($language);
        $label = $language === 'text' ? '' : $language;

        return '<div class="code-block" data-code-block>'
            .'<div class="code-block__toolbar">'
            .($label !== '' ? '<span class="code-block__language">'.e($label).'</span>' : '<span></span>')
            .'<button type="button" class="code-block__copy" data-code-block-copy aria-label="Copy code">'
            .'Copy'
            .'</button>'
            .'</div>'
            .'<pre class="code-block__pre"><code class="code-block__content language-'.e($language).'" data-code-block-content>'
            .$highlighted
            .'</code></pre>'
            .'<template data-code-block-source>'.e($rawCode).'</template>'
            .'</div>';
    }

    private function normalizeLanguage(?string $language): string
    {
        $language = strtolower(trim((string) $language));

        if ($language === '') {
            return 'text';
        }

        if (str_starts_with($language, 'language-')) {
            $language = substr($language, 9);
        }

        return self::LANGUAGE_ALIASES[$language] ?? $language;
    }

    /**
     * @return list<array{type: string, value: string}>
     */
    private function tokenizeMarkup(string $code): array
    {
        $tokens = $this->scan($code, [
            'comment' => '/\{\{--[\s\S]*?--\}\}|<!--[\s\S]*?-->/',
            'echo' => '/\{\{[\s\S]*?\}\}|\{!![\s\S]*?!!\}/',
            'directive' => '/@[A-Za-z_][\w.-]*(?:\((?:[^()"\']++|"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\')*+\))?/',
            'tag' => '/<\/?[\w:.@-]+(?:\s+[^<>]*?)?\/?>/',
            'string' => '/"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'/',
        ]);

        return $this->expandTagTokens($tokens);
    }

    /**
     * @return list<array{type: string, value: string}>
     */
    private function tokenizePhp(string $code): array
    {
        return $this->scan($code, [
            'comment' => '/\/\*[\s\S]*?\*\/|\/\/[^\n]*/',
            'string' => '/"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'/',
            'keyword' => '/\b(?:abstract|and|array|as|break|callable|case|catch|class|clone|const|continue|declare|default|die|do|echo|else|elseif|empty|enddeclare|endfor|endforeach|endif|endswitch|endwhile|enum|eval|exit|extends|final|finally|fn|for|foreach|function|global|goto|if|implements|include|include_once|instanceof|insteadof|interface|isset|list|match|namespace|new|or|print|private|protected|public|readonly|require|require_once|return|static|switch|throw|trait|try|unset|use|var|while|xor|yield)\b/',
            'variable' => '/\$[\w]+/',
            'directive' => '/@[A-Za-z_][\w]*/',
        ]);
    }

    /**
     * @return list<array{type: string, value: string}>
     */
    private function tokenizeBash(string $code): array
    {
        return $this->scan($code, [
            'comment' => '/#[^\n]*/',
            'string' => '/"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'/',
            'flag' => '/(?<=^|\s)--?[\w-]+(?:=[^\s]+)?/',
            'command' => '/(?<=^|\n)[A-Za-z_][\w.-]*/',
        ]);
    }

    /**
     * @return list<array{type: string, value: string}>
     */
    private function tokenizeJson(string $code): array
    {
        return $this->scan($code, [
            'string' => '/"(?:\\\\.|[^"\\\\])*"/',
            'number' => '/-?\d+(?:\.\d+)?(?:[eE][+-]?\d+)?/',
            'keyword' => '/\b(?:true|false|null)\b/',
        ]);
    }

    /**
     * @return list<array{type: string, value: string}>
     */
    private function tokenizeCss(string $code): array
    {
        return $this->scan($code, [
            'comment' => '/\/\*[\s\S]*?\*\//',
            'string' => '/"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'/',
            'selector' => '/[.#][\w-]+/',
            'property' => '/(?<=[\s{;])[\w-]+(?=\s*:)/',
        ]);
    }

    /**
     * @param  array<string, string>  $patterns
     * @return list<array{type: string, value: string}>
     */
    private function scan(string $code, array $patterns): array
    {
        $tokens = [];
        $offset = 0;
        $length = strlen($code);

        while ($offset < $length) {
            $nextMatch = null;
            $nextType = 'plain';
            $nextPos = $length;

            foreach ($patterns as $type => $pattern) {
                if (preg_match($pattern, $code, $matches, PREG_OFFSET_CAPTURE, $offset) !== 1) {
                    continue;
                }

                $match = $matches[0];
                $position = $match[1];

                if ($position < $nextPos) {
                    $nextPos = $position;
                    $nextMatch = $match[0];
                    $nextType = $type;
                }
            }

            if ($nextPos > $offset) {
                $tokens[] = [
                    'type' => 'plain',
                    'value' => substr($code, $offset, $nextPos - $offset),
                ];
            }

            if ($nextMatch === null) {
                break;
            }

            $tokens[] = [
                'type' => $nextType,
                'value' => $nextMatch,
            ];

            $offset = $nextPos + strlen($nextMatch);
        }

        return $tokens;
    }

    /**
     * @param  list<array{type: string, value: string}>  $tokens
     * @return list<array{type: string, value: string}>
     */
    private function expandTagTokens(array $tokens): array
    {
        $expanded = [];

        foreach ($tokens as $token) {
            if ($token['type'] !== 'tag') {
                $expanded[] = $token;

                continue;
            }

            if (! preg_match('/^(<\/?)([\w:.@-]+)(.*?)(\/?>)$/s', $token['value'], $matches)) {
                $expanded[] = $token;

                continue;
            }

            $expanded[] = ['type' => 'punctuation', 'value' => $matches[1]];
            $expanded[] = ['type' => 'tag', 'value' => $matches[2]];

            $rest = $matches[3];

            while ($rest !== '') {
                if (preg_match('/^(\s+)([\w:.@-]+)(=)("(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'|[^\s>]+)/s', $rest, $attributeMatch) === 1) {
                    $expanded[] = ['type' => 'plain', 'value' => $attributeMatch[1]];
                    $expanded[] = ['type' => 'attr', 'value' => $attributeMatch[2]];
                    $expanded[] = ['type' => 'punctuation', 'value' => '='];
                    $expanded[] = ['type' => 'string', 'value' => $attributeMatch[4]];
                    $rest = substr($rest, strlen($attributeMatch[0]));

                    continue;
                }

                $expanded[] = ['type' => 'plain', 'value' => $rest];

                break;
            }

            $expanded[] = ['type' => 'punctuation', 'value' => $matches[4]];
        }

        return $expanded;
    }

    /**
     * @param  list<array{type: string, value: string}>  $tokens
     */
    private function renderTokens(array $tokens): string
    {
        $html = '';

        foreach ($tokens as $token) {
            $value = e($token['value']);

            if ($token['type'] === 'plain') {
                $html .= $value;

                continue;
            }

            $html .= '<span class="code-block__token code-block__token--'.$token['type'].'">'.$value.'</span>';
        }

        return $html;
    }
}
