<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Support\Icon;

use InvalidArgumentException;
use RuntimeException;

final class LucideIconStubGenerator
{
    public function generate(string $iconName, string $svgContents): string
    {
        $name = IconPathResolver::normalizeName($iconName);
        $inner = $this->extractSvgInner($svgContents);

        $escapedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return <<<BLADE
{{-- Icon: {$escapedName} (Lucide, ISC) https://lucide.dev/icons/{$escapedName} --}}
@props([
    'variant' => 'outline',
])

<x-bladex-components::icon.lucide :variant="\$variant" {{ \$attributes }}>
{$inner}
</x-bladex-components::icon.lucide>
BLADE;
    }

    private function extractSvgInner(string $svgContents): string
    {
        if (! preg_match('/<svg\b[^>]*>(.*)<\/svg>/is', $svgContents, $matches)) {
            throw new InvalidArgumentException('Lucide SVG is missing a root <svg> element.');
        }

        $inner = trim($matches[1]);
        $inner = $this->stripSizingAttributes($inner);

        if ($inner === '') {
            throw new RuntimeException('Lucide SVG has no drawable content.');
        }

        return $this->indent($inner, 4);
    }

    private function stripSizingAttributes(string $markup): string
    {
        $markup = preg_replace('/\s(width|height)=["\'][^"\']*["\']/i', '', $markup) ?? $markup;

        return trim($markup);
    }

    private function indent(string $content, int $spaces): string
    {
        $padding = str_repeat(' ', $spaces);
        $lines = preg_split('/\R/', $content) ?: [];

        return collect($lines)
            ->map(static fn (string $line): string => $line === '' ? '' : $padding.$line)
            ->implode("\n");
    }
}
