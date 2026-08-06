<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ComponentSlot;
use Ivanfuhr\StdComponents\Support\Code\CodeHighlighter;

final class CodeBlock extends StdComponent
{
    public function __construct(
        public ?string $language = 'blade',
        public ?string $code = null,
        public bool $copyable = true,
        public bool $inline = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.code-block.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $highlighter = new CodeHighlighter;
        $rawCode = $this->resolveRawCode($data);
        $language = $this->language ?? 'text';
        $highlighted = $highlighter->highlight($rawCode, $language);

        if ($this->inline) {
            return [
                'highlighted' => $highlighted,
                'inlineAttributes' => $this->attributes
                    ->class([
                        'code-block',
                        'code-block--inline',
                        'rounded-md border border-zinc-200 bg-white px-1.5 py-0.5 font-mono text-xs text-zinc-800',
                        'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
                    ])
                    ->merge([
                        'data-code-block' => true,
                        'data-code-block-inline' => true,
                    ]),
            ];
        }

        $wrapperAttributes = $this->attributes
            ->class(['code-block'])
            ->merge([
                'data-code-block' => true,
            ]);

        $preAttributes = (new ComponentAttributeBag)
            ->class([
                'code-block__pre',
                'overflow-x-auto font-mono text-xs leading-relaxed text-zinc-800 dark:text-zinc-200',
            ]);

        $sanitizedLanguage = preg_replace('/[^a-z0-9_-]/i', '', $language) ?? '';

        return [
            'rawCode' => $rawCode,
            'highlighted' => $highlighted,
            'languageLabel' => $language === 'text' ? null : $language,
            'wrapperAttributes' => $wrapperAttributes,
            'preAttributes' => $preAttributes,
            'codeClass' => 'code-block__content language-'.($sanitizedLanguage !== '' ? $sanitizedLanguage : 'text'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function resolveRawCode(array $data): string
    {
        if ($this->code !== null) {
            return $this->code;
        }

        $slot = $data['slot'] ?? null;

        if ($slot instanceof ComponentSlot) {
            return trim($slot->toHtml());
        }

        if (is_string($slot)) {
            return trim($slot);
        }

        return '';
    }
}
